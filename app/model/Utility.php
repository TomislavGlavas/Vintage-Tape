<?php

class Utility
{
    public static function active($path){
        if(Request::pathInfo()===$path){
            return ' class="active"';  
        }
        else{
            return '';
        }
    }

    public static function sumProperties(array $arr, $property) {

        $sum = 0;
    
        foreach($arr as $object) {
            $sum += isset($object->{$property}) ? $object->{$property} : 0;
        }
    
        return $sum;
    }

    public static function inputText($greska,$nazivPolja,$labelaPolja){
        ob_start();
        if(!isset($greska) || $greska['polje']!==$nazivPolja): ?>

        <label>
            <?php echo $labelaPolja ?>
            <input type="text" id="<?php echo $nazivPolja ?>" 
            name="<?php echo $nazivPolja ?>" 
            value="<?php echo App::param($nazivPolja) ?>">
        </label>

    <?php elseif($greska['polje']===$nazivPolja):?>

        <label class="is-invalid-label"> <?php echo $labelaPolja ?>
            <input type="text" id="<?php echo $nazivPolja ?>" 
            name="<?php echo $nazivPolja ?>" 
            value="<?php echo App::param($nazivPolja) ?>"
            class="is-invalid-input">
            <span class="form-error is-visible" id="exemple2Error">
            <?php echo $greska['poruka'] ?>
            </span>
        </label>
    
    <?php endif;

    return ob_get_clean();
    }

    public static function base64Image()
    {
        sleep(1);
        $ch = curl_init ("https://thispersondoesnotexist.com/image");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $raw=curl_exec($ch);
        return 'data:image/jpeg;base64,' . base64_encode($raw);
    }


}