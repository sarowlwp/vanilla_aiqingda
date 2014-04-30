<?php if (!defined('APPLICATION')) exit();

class KarmaRulesModel extends VanillaModel{
    public function __construct() {
        parent::__construct('KarmaRules');
    }

    public function GetRules(){
        return $this->SQL
        ->Select('kr.*')
        ->From('KarmaRules kr')
        ->Where('kr.Remove <>',1)
        ->Get()
        ->Result();
    }
 
    public function GetTally($UserID,$RuleID=null){
        return $this->SQL
        ->Select('krt.*')
        ->From('KarmaRulesTally krt')
        ->Where(
			($RuleID) ?
            array(
                'krt.UserID'=>$UserID,
                'krt.RuleID'=>$RuleID
            )
            :
            array(
                'krt.UserID'=>$UserID,
            )
        )
        ->Get()
        ->Result();
    }
 
    public function SetTally($UserID,$RuleID,$Value){
        if($this->GetTally($UserID,$RuleID)){
            $this->SQL
            ->Update('KarmaRulesTally',
                array(
                    'Value'=>$Value,
                )
            )
            ->Where(
                array(
                    'UserID'=>$UserID,
                    'RuleID'=>$RuleID,
                )
            )
            ->Put();
        }else{
            $this->SQL
            ->Insert('KarmaRulesTally',
                array(
                    'UserID'=>$UserID,
                    'RuleID'=>$RuleID,
                    'Value'=>$Value,
                )
            );
        }
    }
 
    public function SetRule($Condition,$Operation,$Target,$Amount){
        $this->SQL
        ->Insert('KarmaRules',
            array(
                'Condition'=>$Condition,
                'Operation'=>$Operation,
                'Target'=>$Target,
                'Amount'=>$Amount
            )
        );
		
    }
 
    public function RemoveRule($RuleID){
        $this->SQL
        ->Update('KarmaRules',
            array(
                'Remove'=>1
            )
        )
        ->Where(
            array(
                'RuleID'=>$RuleID
            )
        )
        ->Put();
    }

}
