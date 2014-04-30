<?php
if (!defined('APPLICATION'))
    exit();


$Session = Gdn::Session();
if (!Gdn::Session()->CheckPermission('Garden.Users.Edit'))
    exit();




ini_set("auto_detect_line_endings", true);
$filename = "plugins/Cleanser/list/cleanserlisttxt";

$this->AddCssFile('cleanser.css', 'plugins/Cleanser');

if (file_exists($filename)) {
    $fp = fopen($filename, 'r');
    $infoline = fgets($fp);

    echo '<a href="index.php?p=/settings/cleanser">Back to Cleanser Settings </a>';

    echo "<h3> $infoline </h3>";
    echo "<table>";
    $Alt = FALSE;


    echo "<tr><th> userid </th> <th> username</th><th class=\"rolecol\"> roles</th><th> email</th><th>ip address</th><th> last visit</th><th> Discussion Count</th><th>Comment Count</th><th class=\"aboutcol\">About</th> <th class=\"discovcol\">Discovery Test</th>    </tr> ";

    while (!feof($fp)) {
        $infoline = fgets($fp);
        $parts = explode('|', $infoline);
        $Alt = $Alt ? FALSE : TRUE;
        ?>
        <tr<?php echo $Alt ? ' class="Alt"' : ''; ?>>
            <?php
            if (is_numeric($parts[0])) {


                echo "<td>";
                echo htmlspecialchars($parts[0]);
                echo "</td><td>";
                echo htmlspecialchars($parts[1]);
                echo "</td>";
                echo '<td class=\"rolecol\">';
                echo htmlspecialchars($parts[2]);
                echo "</td><td>";
                echo htmlspecialchars($parts[3]);
                echo "</td><td>";
                echo htmlspecialchars($parts[4]);
                echo "</td><td>";
                echo htmlspecialchars($parts[5]);
                echo "</td><td>";
                echo htmlspecialchars($parts[6]);
                echo "</td><td>";
                echo htmlspecialchars($parts[7]);
                echo "</td>";
                echo '<td class=\"aboutcol\">';
                echo htmlspecialchars($parts[8]);
                echo "</td>";
                echo '<td class=\"discovcol\">';
                echo htmlspecialchars($parts[9]);
                echo "</td>  </tr>";
            }
        }
        echo "</table>";
        fclose($file);
    }

    $Alt = $Alt ? FALSE : TRUE;
    ?>
<tr<?php echo $Alt ? ' class="Alt"' : ''; ?>>

