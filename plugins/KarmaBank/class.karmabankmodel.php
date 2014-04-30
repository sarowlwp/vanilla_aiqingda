<?php if(!defined('APPLICATION')) exit();

class KarmaBankModel extends VanillaModel{
    
    private $UserID;
    private static $FC;

    public function __construct($UserID) {
        parent::__construct('KarmaBank');
        $this->UserID=$UserID;
        if(!self::$FC)
			self::$FC = new Gdn_Filecache();
        
        //$this->FC->AddContainer(array(Gdn_Cache::CONTAINER_LOCATION=>PATH_LOCAL_CACHE.'/karmacache'));
        self::$FC->AddContainer(array(Gdn_Cache::CONTAINER_LOCATION=>'./cache/karmacache/'));
       
    }
    
    public function CheckForCollissions($Type,$Amount,$Value=0){
        return self::$FC->Exists($this->UserID.'|'.$Type.'|'.$Amount.'|'.$Value);
    }

    public function Transaction($Type,$Amount,$Value=0,$RuleID=0){
        if(!is_numeric($Amount))
            return;
        //Using file cache to psuedo-lock
        $Lock = $this->UserID.'|'.$Type.'|'.$Amount.'|'.$Value;
		self::$FC->Add($Lock,1,array(Gdn_Cache::FEATURE_EXPIRY => C('Plugins.KarmaBank.CacheExpire',1000)));
        
        $Amount=number_format($Amount,2,'.','');
        $CurrentBalance = $this->SQL
        ->Select('kb.*')
        ->From('KarmaBankBalance kb')
        ->Where('kb.UserID',$this->UserID)
        ->Get()
        ->FirstRow();

        $this->SQL->Insert('KarmaBankTrans',
            array(
                'UserID'=>$this->UserID,
                'Date'=>Gdn_Format::ToDateTime(),
                'Amount'=>$Amount,
                'Type'=>$Type
            )
        );
        
        if($RuleID && $Value){
			$TransTally = $this->SQL
				->Select('kbtt.*')
				->From('KarmaBankTransTally kbtt')
				->Where(
					array(
						'UserID'=>$this->UserID,
						'RuleID'=>$RuleID,
					)
				)
				->Get();
			if(!$TransTally->NumRows()){
				$this->SQL->Insert('KarmaBankTransTally',
					array(
						'UserID'=>$this->UserID,
						'RuleID'=>$RuleID,
						'LastTally'=>$Value
					)
				);
			}else{;
				$this->SQL->Update('KarmaBankTransTally',
					array(
						'LastTally'=>$Value
					),
					array(
						'UserID'=>$this->UserID,
						'RuleID'=>$RuleID
					)
				)
				->Put();
			}
		}
			
        if(!$CurrentBalance){
            $this->SQL->Insert('KarmaBankBalance',
                array(
                    'UserID'=>$this->UserID,
                    'Balance'=>$Amount
                )
            );
        }else{
            $this->SQL->Update('KarmaBankBalance',
                array(
                    'Balance'=>number_format($CurrentBalance->Balance,2,'.','')+$Amount,
                    'TransCount'=>$CurrentBalance->TransCount+1
                ),
                array(
                    'UserID'=>$this->UserID
                )
            )
            ->Put();
        }
        self::$FC->Store($Lock,1,array(Gdn_Cache::FEATURE_EXPIRY => C('Plugins.KarmaBank.CacheExpire',-1)));
        self::$FC->Remove($Lock);
    }
  
    public function GetTransactionList($Limit=5, $Offset=0,$Order='desc'){
        return $this->SQL
        ->Select('kbt.*')
        ->From('KarmaBankTrans kbt')
        ->Where('kbt.UserID',$this->UserID)
        ->OrderBy('kbt.TransID', strtolower($Order)=='desc'?'desc':'asc')
        ->Limit($Limit, $Offset)
        ->Get()
        ->Result();
    }
    
    public function GetLastTransactionTally(){
        return $this->SQL
        ->Select('kbtt.*')
        ->From('KarmaBankTransTally kbtt')
        ->Where('kbtt.UserID',$this->UserID)	
        ->Get()
        ->Result();	
    }
      
    public function GetBalance(){
        return $this->SQL
        ->Select('kb.*')
        ->From('KarmaBankBalance kb')
        ->Where('kb.UserID',$this->UserID)
        ->Get()
        ->FirstRow();
    }
    
    public function GetBalances($UserIDs){
        return $this->SQL
        ->Select('kb.*')
        ->From('KarmaBankBalance kb')
        ->WhereIn('kb.UserID',$UserIDs)
        ->Get()
        ->Result();
    }

}
