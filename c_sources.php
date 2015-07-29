<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of c_sources
 *
 * @author echiteri
 */
class c_sources {
    //put your code here
    public function reconstructRegimen($str)
    {
        switch ($str)
        {
            case "AF1A":
                $str = "AZT + 3TC + NVP";
                break;
            case "AF1B":
                $str = "AZT + 3TC + EFV";
                break;
            case "AF2A":
                $str = "TDF + 3TC + NVP";
                break;
            case "AF2B":
                $str = "TDF + 3TC + EFV";
                break;
            case "AS1A":
                $str = "AZT + 3TC + LPV/r";
                break;
            case "AS1C":
                $str = "AZT + 3TC + ABC";
                break;
            case "AS2A":
                $str = "TDF + 3TC + LPV/r";
                break;
            case "AS2B":
                $str = "TDF + 3TC + ABC";
                break;
            case "AS2D":
                $str = "TDF + ABC + LPV/r";
                break;
            case "AS2E":
                $str = "TDF + AZT + LPV/r";
                break;
            default :
                $str = "";
                break;
                
                    
        }
        return $str;
    }
    public function printRegimen($str)
    {
        //this can be done simpler and consitently
       $select = "<option selected=''>Select the regimen/code  of triple ARV therapy </option>";
        if($str == "AF1A" ) { $select .= "<option value='AF1A' selected=''>AZT + 3TC + NVP</option>"; } else {$select .=  "<option value='AF1A' >AZT + 3TC + NVP</option>"; }
        if($str == "AF1B" ) { $select .=  "<option value='AF1B' selected=''>AZT + 3TC + EFV</option>"; } else {$select .=  "<option value='AF1B' >AZT + 3TC + EFV</option>"; }
        if($str == "AF2A" ) { $select .=  "<option value='AF2A' selected=''>TDF + 3TC + NVP</option>"; } else {$select .=  "<option value='AF2A' >TDF + 3TC + NVP</option>"; }
        if($str == "AF2B" ) { $select .=  "<option value='AF2B' selected=''>TDF + 3TC + EFV</option>"; } else {$select .=  "<option value='AF2B' >TDF + 3TC + EFV</option>"; }
        if($str == "AF1A" ) { $select .=  "<option value='AF1A' selected=''>AZT + 3TC + NVP</option>"; } else {$select .=  "<option value='AF1A' >AZT + 3TC + NVP</option>"; }

        if($str == "AS1A" ) { $select .= "<option value='AS1A' selected=''>AZT + 3TC + LPV/r</option>"; } else {$select .=  "<option value='AS1A' >AZT + 3TC + LPV/r</option>"; }
        if($str == "AS1C" ) { $select .=  "<option value='AS1C' selected=''>AZT + 3TC + ABC</option>"; } else {$select .=  "<option value='AS1C'>AZT + 3TC + ABC</option>"; }
        if($str == "AS2A" ) { $select .=  "<option value='AS2A' selected=''>TDF + 3TC + LPV/r</option>"; } else {$select .=  "<option value='AS2A' >TDF + 3TC + LPV/r</option>"; }
        if($str == "AS2B" ) { $select .=  "<option value='AS2B' selected=''>TDF + 3TC + ABC</option>"; } else {$select .=  "<option value='AS2B' >TDF + 3TC + ABC</option>"; }
        if($str == "AS2D" ) { $select .=  "<option value='AS2D' selected=''>TDF + ABC + LPV/r</option>"; } else {$select .=  "<option value='AS2D' >TDF + ABC + LPV/r</option>"; }
        if($str == "AS2E" ) { $select .=  "<option value='AS2E' selected=''>TDF + AZT + LPV/r</option>"; } else {$select .=  "<option value='AS2E' >TDF + AZT + LPV/r</option>"; }

                                                
        /*  <option selected="selected">Select the regimen/code  of triple ARV therapy </option>
            <option value="AF1A" >AZT + 3TC + NVP</option>
            <option value="AF1B" selected="<?php //if($select_record["haart_regimen"] == "AF1B"){echo "TRUE";}?>">AZT + 3TC + EFV</option>
            <option value="AF2A" selected="<?php //if($select_record["haart_regimen"] == "AF2A"){echo "TRUE";}?>">TDF + 3TC + NVP</option>
            <option value="AF2B" selected="<?php //if($_REQUEST["action"] == "edit"){ if($select_record["haart_regimen"] == "AF2B"){echo "FALSE";}}?>">TDF + 3TC + EFV</option>
            <option value="AS1A" selected="">AZT + 3TC + LPV/r</option>
            <option value="AS1C" selected="false">AZT + 3TC + ABC</option>
            <option value="AS2A">TDF + 3TC + LPV/r</option>
            <option value="AS2B">TDF + 3TC + ABC</option>
            <option value="AS2D">TDF + ABC + LPV/r</option>
            <option value="AS2E">TDF + AZT + LPV/r</option>                                                */
        return $select;
    }
    public function printEffects($str)
    {
        //this can be done simpler and consitently
       $select = "";//<option selected=''>Select unpleasant effects of ART</option>";
        if($str == "N" ) { $select = "<option value='N' selected=''>Nausea</option>"; } else {$select =  "<option value='N' >Nausea</option>"; }
        if($str == "H" ) { $select .=  "<option value='H' selected=''>Headache</option>"; } else {$select .=  "<option value='H' >Headache</option>"; }
        if($str == "A" ) { $select .=  "<option value='A' selected=''>Anaemia</option>"; } else {$select .=  "<option value='A' >Anaemia</option>"; }
        if($str == "F" ) { $select .=  "<option value='F' selected=''>Fatigue</option>"; } else {$select .=  "<option value='F' >Fatigue</option>"; }
        if($str == "FAT" ) { $select .=  "<option value='FAT' selected=''>FAT</option>"; } else {$select .=  "<option value='FAT' >FAT</option>"; }

        if($str == "BN" ) { $select .= "<option value='BN' selected=''>Burning</option>"; } else {$select .=  "<option value='BN' >Burning</option>"; }
        if($str == "CNS" ) { $select .=  "<option value='CNS' selected=''>Dizzy/Nightmares/Anxiety</option>"; } else {$select .=  "<option value='CNS'>Dizzy/Nightmares/Anxiety</option>"; }
        if($str == "R" ) { $select .=  "<option value='R' selected=''>Rash</option>"; } else {$select .=  "<option value='R' >Rash</option>"; }
        if($str == "D" ) { $select .=  "<option value='D' selected=''>Diarrhoea</option>"; } else {$select .=  "<option value='D' >Diarrhoea</option>"; }
        if($str == "J" ) { $select .=  "<option value='J' selected=''>Jaundice</option>"; } else {$select .=  "<option value='J' >Jaundice</option>"; }
        if($str == "AB" ) { $select .=  "<option value='AB' selected=''>Abdominal pain</option>"; } else {$select .=  "<option value='AB' >Abdominal pain</option>"; }

                                                
        /* <option selected="">Select unpleasant effects of ART</option>
            <option value="N">Nausea</option>
            <option value="H">Headache</option>
            <option value="A">Anaemia</option>
            <option value="F">Fatigue</option>
            <option value="FAT">FAT Changes</option>
            <option value="BN">Burning</option>
            <option value="CNS">Dizzy/Nightmares/Anxiety</option>
            <option value="R">Rash</option>
            <option value="D">Diarrhoea</option>
            <option value="J">Jaundice</option>
            <option value="AB">Abdominal pain</option>                                                */
        return $select;
    }
    public function printAdherence($str)
    {
         $select = "";// "<option selected=''>Select participant's self report of taking ART exactly as prescribed</option>";
        if($str == "G" ) { $select = "<option value='G' selected=''>Good (>95%)</option>"; } else {$select =  "<option value='G' >Good (>95%)</option>"; }
        if($str == "F" ) { $select .=  "<option value='F' selected=''>Fair (85% - 94%)</option>"; } else {$select .=  "<option value='F' >Fair (85% - 94%)</option>"; }
        if($str == "P" ) { $select .=  "<option value='P' selected=''>Poor (<85%)</option>"; } else {$select .=  "<option value='P' >Poor (<85%)</option>"; }
       
            /*<option selected="">Select participant's self report of taking ART exactly as prescribed</option>
           <option value="G">Good (>95%)</option>
           <option value="F">Fair (85% - 94%)</option>
           <option value="P">Poor (<85%)</option>*/
        return $select;
    }
    
    public function printWho($str)
    {
         $select = "";// "<option selected=''>Select participant's self report of taking ART exactly as prescribed</option>";
        if($str == "WHO stage I" ) { $select = "<option value='WHO stage I' selected=''>WHO stage I</option>"; } else {$select =  "<option value='WHO stage I' >WHO stage I</option>"; }
        if($str == "WHO stage II" ) { $select .= "<option value='WHO stage II' selected=''>WHO stage II</option>"; } else {$select .=  "<option value='WHO stage II' >WHO stage II</option>"; }
        if($str == "WHO stage III" ) { $select .= "<option value='WHO stage III' selected=''>WHO stage III</option>"; } else {$select .=  "<option value='WHO stage III' >WHO stage III</option>"; }
        if($str == "WHO stage IV" ) { $select .= "<option value='WHO stage IV' selected=''>WHO stage IV</option>"; } else {$select .=  "<option value='WHO stage IV' >WHO stage IV</option>"; }
       
        return $select;
        /*<option value="WHO stage I">WHO stage I</option>
        <option value="WHO stage II">WHO stage II</option>
        <option value="WHO stage III">WHO stage III</option>
        <option value="WHO stage IV">WHO stage IV</option>*/
    }
}
