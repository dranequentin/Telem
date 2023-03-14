<?php
/**
 * @param $minimum
 * @return bool true si le nombre de charactére est inférieure à celui passé en argument
 */
function minLenght($zoneConstraint,$minimum){
    if (strlen($_POST[$zoneConstraint]) <$minimum){
        return true;
}else{
        return false;
    }
}
/**
 * @param $maximum
 * @return bool true si le nombre de charactére est supérieur à celui passé en argument
 */
function maxLenght($zoneConstraint,$maximum){
    if (strlen($_POST[$zoneConstraint]) >$maximum){
        return true;
}else{
        return false;
    }
}