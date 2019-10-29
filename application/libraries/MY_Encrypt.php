<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Encryption Class
 *
 * Provides two-way keyed encoding using Mcrypt
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/encryption.html
 */
class MY_Encrypt extends CI_Encrypt {

	/**
	 * Encode
	 *
	 * Encodes the message string using bitwise XOR encoding.
	 * The key is combined with a random hash, and then it
	 * too gets converted using XOR. The whole thing is then run
	 * through mcrypt using the randomized key. The end result
	 * is a double-encrypted message string that is randomized
	 * with each call to this function, even if the supplied
	 * message and key are the same.
	 *
	 * @param	string	the string to encode
	 * @param	string	the key
	 * @return	string
	 */
	public function encode($string,$key = '')
	{
        
        //return base64_encode($this->mcrypt_encode($string, $this->get_key($key)));
        return $this->encrypt($string,$this->get_key());
        //return 'ok';
    }

	// --------------------------------------------------------------------

	/**
	 * Decode
	 *
	 * Reverses the above process
	 *
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	public function decode($string,$key = '')
	{
		if (preg_match('/[^a-zA-Z0-9\/\+=]/', $string) OR base64_encode(base64_decode($string)) !== $string)
		{
			return FALSE;
		}

        //return $this->mcrypt_decode(base64_decode($string), $this->get_key($key));
        return $this->decrypt($string,$this->get_key());
        //return 'ok';
	}

    function encrypt($payload,$key) {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($payload, 'aes-256-cbc', $key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }

    function decrypt($garble,$key) {
        list($encrypted_data, $iv) = explode('::', base64_decode($garble), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
    }
}
