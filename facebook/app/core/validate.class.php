<?php

class Validate {
    
    public static function isEmail ($string) {
        return preg_match('/[A-z0-9\-]+@([A-z0-9\-]+)(\.[A-z0-9]+){1,2}/im', $string);
    }
    
    public static function isCharacter ($string) {
        return preg_match('/[A-z\sÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚĂĐĨŨƠàáâãèéêìíòóôõùúăđĩũơƯĂẠẢẤẦẨẪẬẮẰẲẴẶẸẺẼỀỀỂưăạảấầẩẫậắằẳẵặẹẻẽềềểỄỆỈỊỌỎỐỒỔỖỘỚỜỞỠỢỤỦỨỪễệỉịọỏốồổỗộớờởỡợụủứừỬỮỰỲỴÝỶỸửữựỳỵỷỹ]+/im', $string);
    }

    public static function isUrlYoutube ($str) {
    	return preg_match ('/https?:\/\/(?:youtu\.be\/|(?:[a-z]{2,3}\.)?youtube\.com\/watch(?:\?|#\!)v=)([\w-]{11}).*/i', $str);
    }
    
}

?>