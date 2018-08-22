<?php

class EncryptLibrary {

    protected $CI;
    
    private $iv;
    private $key;
    
    public function __construct(){
        $this->CI =& get_instance();
        
        $this->iv  = "AvWEGijgrWERbORY";
        $this->key = "ASERGYJIKOÇPBXFV";
    }
    
    public function encrypt(string $source, string $dest){
        $length = filesize($source);
        
        $error = false;
        if ($fpOut = fopen($dest, 'w')) {
            if ($fpIn = fopen($source, 'rb')) {
                
                $plaintext = fread($fpIn, $length);
                $ciphertext = openssl_encrypt($plaintext, 'AES-128-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv);

                fwrite($fpOut, $ciphertext);
                fclose($fpIn);
                
            } else {
                $error = true;
            }
            
            fclose($fpOut);
            
        } else {
            $error = true;
        }
        
        return $error ? false : $dest;
    }
    
    public function decrypt(string $source, string $dest){
        $length = filesize($source);
        
        $error = false;
        if ($fpOut = fopen($dest, 'w')) {
            if ($fpIn = fopen($source, 'rb')) {

                $ciphertext = fread($fpIn, $length);
                $plaintext = openssl_decrypt($ciphertext, 'AES-128-CBC', $this->key, OPENSSL_RAW_DATA, $this->iv);
                
                fwrite($fpOut, $plaintext);
                fclose($fpIn);
                
            } else {
                $error = true;
            }
            
            fclose($fpOut);
            
        } else {
            $error = true;
        }
        
        return $error ? false : $dest;
    }
    
}