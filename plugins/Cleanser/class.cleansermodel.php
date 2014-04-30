<?php

if (!defined('APPLICATION'))
    exit();

class CleanserModel extends VanillaModel {

    public function GetRoleList() {

        $RoleModel = new Gdn_Model('Role');
        $Roledata = $RoleModel->SQL
                ->Select('RoleID,Name')
                ->From('Role')
                ->Get();


        $Rarray = $Roledata->ResultArray();
        for ($x = 0; $x < count($Rarray); $x++) {

            $rname = $Rarray[$x]['Name'] . " (" . $Rarray[$x]['RoleID'] . ")";
            $rid = $Rarray[$x]['RoleID'];
            $rsub = strtolower(substr($rname, 0, 3));
            if (($rsub <> "adm") && ($rsub <> "mod") && ($rsub <> "gue")) {
                $RoleIdArray[$rid] = $rname;
            }
        }

        return $RoleIdArray;
    }

    public function CreateCleanserList($therole, $theIPAddress = "", $offset = "0", $maxrecords = "100", $DiscoveryPatternSet = "") {
        $filename = "plugins/Cleanser/list/cleanserlisttxt";



        if (!$fp = fopen($filename, "w")) {
            echo "you need to set your file permissions correctly.  Cannot open file ($filename)";
            exit;
        }
        $today = date("F j, Y, g:i a");

        //pattern to match

        $DiscoveryPatternSet = trim($DiscoveryPatternSet);


        $infoIP = ($theIPAddress == "" ? '' : "IpAddress:$theIPAddress");
        $info = "File Creation Time - $today RoleID:$therole  $infoIP (Offset:$offset MR:$maxrecords)" . "pattern: $DiscoveryPatternSet" . PHP_EOL;
        fwrite($fp, $info);


        $UserListModel = new Gdn_Model('User');
        $SQL = $UserListModel->SQL
                ->Select('u.UserID,u.Name,u.Email,u.UpdateIPAddress,u.DateLastActive,u.CountDiscussions,u.CountComments,u.About,u.DiscoveryText')
                ->From('UserRole ur')
                ->Join('User u', 'ur.UserID = u.UserID')
                ->Where('ur.RoleId', $therole);
        if ($theIPAddress != "")
            $SQL->Where('u.UpdateIPAddress', $theIPAddress);
        $UserListdata = $SQL->Offset($offset)->Limit($maxrecords)->Get();

        $Result = $UserListdata->ResultArray();

        $UserRModel = new UserModel();

        $UserRModel->GetRoles($UserID)->ResultArray();

        while (list($key, $value) = each($Result)) {
            if ($DiscoveryPatternSet != "") {
                $Match = "";
                $DisText = $value["DiscoveryText"];
                $newpatternset = str_replace(array('.', '[', ']', '{', '}', '/'), 'X', $DiscoveryPatternSet);
                $newDisText = str_replace(array('.', '[', ']', '{', '}', '/'), 'X', $DisText);
                preg_match("/" . $newpatternset . "/", $newDisText, $Match);

                if ($Match) {
                    $UID = $value["UserID"];
                    $UserRoleData = $UserRModel->GetRoles($UID)->ResultArray();
                    //  $RoleIDs = ConsolidateArrayValuesByKey($UserRoleData, 'RoleID');
                    $RoleNamesArr = ConsolidateArrayValuesByKey($UserRoleData, 'Name');
                    $Rolenames = implode($RoleNamesArr, ", ");
                    $val = $value["UserID"] . "|" . $value["Name"] . "|" . $Rolenames . "|" . $value["Email"] . "|" . $value["UpdateIPAddress"] . "|" . Gdn_Format::Date($value["DateLastActive"]) . "|" . $value["CountDiscussions"] . "|" . $value["CountComments"] . "|" . $value["About"] . "|" . $value["DiscoveryText"] . PHP_EOL;

                    fwrite($fp, $val);
                }
            } else {
                $UID = $value["UserID"];
                $UserRoleData = $UserRModel->GetRoles($UID)->ResultArray();
                //  $RoleIDs = ConsolidateArrayValuesByKey($UserRoleData, 'RoleID');
                $RoleNamesArr = ConsolidateArrayValuesByKey($UserRoleData, 'Name');
                $Rolenames = implode($RoleNamesArr, ", ");
                $val = $value["UserID"] . "|" . $value["Name"] . "|" . $Rolenames . "|" . $value["Email"] . "|" . $value["UpdateIPAddress"] . "|" . Gdn_Format::Date($value["DateLastActive"]) . "|" . $value["CountDiscussions"] . "|" . $value["CountComments"] . "|" . $value["About"] . "|" . $value["DiscoveryText"] . PHP_EOL;
                fwrite($fp, $val);
            }
        }
        fclose($fp);
    }

    public function DeleteAction($IdToDelete) {

        //  /*
        if (is_numeric($IdToDelete)) {
            echo "deleting user id - $IdToDelete <br />";
        }
        // */
        $UserModel = new UserModel();

        if (is_numeric($IdToDelete)) {
            $UserModel->Delete($IdToDelete, array('DeleteMethod' => "delete"));
        }



        //  keep -   Delete the user but keep the user's content.
        //   wipe -  Delete the user and replace all of the user's 
        //           content with a message stating the user has been deleted. 
        //           This gives a visual cue that there is missing information.
        //  delete - Delete the user and completely remove all of the user's content. 
        //     
        //    array('DeleteMethod' => "wipe"));
        //    array('DeleteMethod' => "delete"));
        // now Totally delete the individual [Deleted User] for the user table

        Gdn::SQL()->Delete('User', array('UserID' => $IdToDelete));
    }

}
