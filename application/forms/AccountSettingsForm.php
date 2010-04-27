<?php
/**
 *  AccountSettingsForm -> Form for account settings
 *
 * 	Copyright (c) <2009>, Markus Riihelä
 * 	Copyright (c) <2009>, Mikko Sallinen
 *  Copyright (c) <2009>, Joel Peltonen
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License 
 * as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied  
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for  
 * more details.
 * 
 * You should have received a copy of the GNU General Public License along with this program; if not, write to the Free 
 * Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * License text found in /license/
 */

/**
 *  AccountSettingsForm - class
 *
 *  @package 	Forms
 *  @author 	Markus Riihelä, Mikko Sallinen, Joel Peltonen
 *  @copyright 	2009 Markus Riihelä & Mikko Sallinen
 *  @license 	GPL v2
 *  @version 	1.0
 */
 
class Default_Form_AccountSettingsForm extends Zend_Form
{
    public function __construct($options = null) 
    { 
        parent::__construct($options);
		try{
		$translate = Zend_Registry::get('Zend_Translate'); 
		
		$this->setName('account_settings_form');
		$this->addElementPrefixPath('Oibs_Decorators', 
								'Oibs/Decorators/',
								'decorator');
		
		$mailvalid = new Zend_Validate_EmailAddress();
		$mailvalid->setMessage(
			'email-invalid',
			Zend_Validate_EmailAddress::INVALID);
		$mailvalid->setMessage(
			'email-invalid-hostname',
			Zend_Validate_EmailAddress::INVALID_HOSTNAME);
		$mailvalid->setMessage(
			'email-invalid-mx-record',
			Zend_Validate_EmailAddress::INVALID_MX_RECORD);
		$mailvalid->setMessage(
			'email-dot-atom',
			Zend_Validate_EmailAddress::DOT_ATOM);
		$mailvalid->setMessage(
			'email-quoted-string',
			Zend_Validate_EmailAddress::QUOTED_STRING);
		$mailvalid->setMessage(
			'email-invalid-local-part',
			Zend_Validate_EmailAddress::INVALID_LOCAL_PART);
		$mailvalid->setMessage(
			'email-length-exceeded',
			Zend_Validate_EmailAddress::LENGTH_EXCEEDED);
		$mailvalid->hostnameValidator->setMessage(
			'hostname-invalid-hostname',
			Zend_Validate_Hostname::INVALID_HOSTNAME);
		$mailvalid->hostnameValidator->setMessage(
			'hostname-local-name-not-allowed',
			Zend_Validate_Hostname::LOCAL_NAME_NOT_ALLOWED);
		$mailvalid->hostnameValidator->setMessage(
			'hostname-unknown-tld',
			Zend_Validate_Hostname::UNKNOWN_TLD);	
		$mailvalid->hostnameValidator->setMessage(
			'hostname-invalid-local-name',
			Zend_Validate_Hostname::INVALID_LOCAL_NAME);	
		$mailvalid->hostnameValidator->setMessage(
			'hostname-undecipherable-tld',
			Zend_Validate_Hostname::UNDECIPHERABLE_TLD);
            
		$translate = Zend_Registry::get('Zend_Translate');
        $description = $translate->translate("account-profile-public");
        
		// First name input form element
		$firstname = new Zend_Form_Element_Text('firstname');
		$firstname->setLabel($translate->_("account-profile-first-name"))
				//->setRequired(true)
				//->addFilter('StringtoLower')
				->addValidators(array(
				array('NotEmpty', true, array('messages' => array('isEmpty' => 'Empty'))), 
				))
				->setDecorators(array('SettingsTextDecorator'));
                
        $firstname_publicity = new Zend_Form_Element_Checkbox('firstname_publicity');
		$firstname_publicity->setDecorators(array('SettingsCheckboxDecorator'))
                ->setDescription($description);
		
		// Surname input form element
		$surname = new Zend_Form_Element_Text('surname');
		$surname->setLabel($translate->_("account-profile-surname"))
				//->setRequired(true)
				//->addFilter('StringtoLower')
				->addValidators(array(
				array('NotEmpty', true, array('messages' => array('isEmpty' => 'Empty'))), 
				))
				->setDecorators(array('SettingsTextDecorator'));
                
        $surname_publicity = new Zend_Form_Element_Checkbox('surname_publicity');
		$surname_publicity->setDecorators(array('SettingsCheckboxDecorator'))
                ->setDescription($description);
		
		// Gender input form element
		$gender = new Zend_Form_Element_Select('gender');
		$gender->setLabel($translate->_("Gender"))
				->addFilter('StringtoLower')				
				->setDecorators(array('SettingsSelectDecorator'))
				->setMultiOptions(array(1=>"Male",2=>"Female"));
             
        $gender_publicity = new Zend_Form_Element_Checkbox('gender_publicity');
		$gender_publicity->setDecorators(array('SettingsCheckboxDecorator'))
                ->setDescription($description);
				
		// Profession input form element
		$profession = new Zend_Form_Element_Text('profession');
		$profession->setLabel($translate->_("account-profile-profession"))
					->addValidators(array(
							array('NotEmpty', true, array('messages' => array('isEmpty' => 'Empty'))), 
							))
					->setDecorators(array('SettingsTextDecorator'));
                    
        $profession_publicity = new Zend_Form_Element_Checkbox('profession_publicity');
		$profession_publicity->setDecorators(array('SettingsCheckboxDecorator'))
                ->setDescription($description);
		
		// Company input form element
		$com = new Zend_Form_Element_Text('company');
		$com->setLabel($translate->_("account-profile-company"))
					->addValidators(array(
							array('NotEmpty', true, array('messages' => array('isEmpty' => 'Empty'))), 
							))
					->setDecorators(array('SettingsTextDecorator'));
                    
        // $com_publicity = new Zend_Form_Element_Checkbox('com_publicity');
        $com_publicity = new Zend_Form_Element_Checkbox('company_publicity');
		$com_publicity->setDecorators(array('SettingsCheckboxDecorator'))
                ->setDescription($description);
					
		// City input form element
		$city = new Zend_Form_Element_Text('city');
		$city->setLabel($translate->_("account-profile-city"))
					->addValidators(array(
							array('NotEmpty', true, array('messages' => array('isEmpty' => 'Empty'))), 
							))
					->setDecorators(array('SettingsTextDecorator'));
                
        $city_publicity = new Zend_Form_Element_Checkbox('city_publicity');
		$city_publicity->setDecorators(array('SettingsCheckboxDecorator'))
                ->setDescription($description);
		
		// Phone input form element
		$phone = new Zend_Form_Element_Text('phone');
		$phone->setLabel($translate->_("account-profile-phone"))
					->addValidators(array(
							array('NotEmpty', true, array('messages' => array('isEmpty' => 'Empty'))), 
							))
					->setDecorators(array('SettingsTextDecorator'));
        
        $phone_publicity = new Zend_Form_Element_Checkbox('phone_publicity');
		$phone_publicity->setDecorators(array('SettingsCheckboxDecorator'))
                ->setDescription($description);
					
		// OpenID input form element !! ADD DUPE VALIDATOR !!
		$openID = new Zend_Form_Element_Text('openid');
		$openID->setLabel($translate->_("account-profile-openid"))
					->addValidators(array(
							new Oibs_Validators_OpenidExists(),
							array('NotEmpty', true, array('messages' => array('isEmpty' => 'Empty'))), 
							))
					->setDecorators(array('CustomDecorator'));
       
        // lets not allow publicity for this one just yet
        // $openID_publicity = new Zend_Form_Element_Checkbox('openID_publicity');
        // $openID_publicity->setDecorators(array('SettingsCheckboxDecorator'))
        //           ->setDescription($description);
		
		// Birthday input form element
		$birth = new Zend_Form_Element_Text('birthday');
		$birth->setLabel($translate->_("account-profile-birth"))
					->addValidators(array(
							array('NotEmpty', true, array('messages' => array('isEmpty' => 'Empty'))), 
							))
					->setDecorators(array('SettingsTextDecorator'));
                    
        // $birth_publicity = new Zend_Form_Element_Checkbox('birth_publicity');
        $birth_publicity = new Zend_Form_Element_Checkbox('birthday_publicity');
		$birth_publicity->setDecorators(array('SettingsCheckboxDecorator'))
                ->setDescription($description);
					
		// Biography input form element
		$bio = new Zend_Form_Element_Text('biography');
		$bio->setLabel($translate->_("account-profile-biography"))
					->addValidators(array(
							array('NotEmpty', true, array('messages' => array('isEmpty' => 'Empty'))), 
							))
					//->setAttrib('rows','4')
					//->setAttrib('cols','31')
					->setDecorators(array('SettingsTextDecorator'));	

        // $bio_publicity = new Zend_Form_Element_Checkbox('bio_publicity');
        $bio_publicity = new Zend_Form_Element_Checkbox('biography_publicity');
		$bio_publicity->setDecorators(array('SettingsCheckboxDecorator'))
                ->setDescription($description);                    
		
		//Country input form element
		$country =  new Zend_Form_Element_Select('country');
		$country->setLabel($translate->_('Country'))
				->setDecorators(array('SettingsSelectDecorator'));
		$countries = new Default_Model_UserCountry();
		$a = $countries->fetchAll();  
		foreach ($a as $b)
		{
			$countryarray[$b->id_ctr]=$b->name_ctr;
		}
		if (isset($countryarray) )
			$country->setMultiOptions($countryarray);		
		else 
			$country->setMultiOptions(array("None",""));

        $country_publicity = new Zend_Form_Element_Checkbox('country_publicity');
		$country_publicity->setDecorators(array('SettingsCheckboxDecorator'))
                ->setDescription($description);             
		
		// E-mail input form element
		$email = new Zend_Form_Element_Text('email');
		$email->setLabel($translate->_("account-register-email"))
				//->setRequired(true)
				->addFilter('StringtoLower')
				->addValidators(array(
                    new Oibs_Validators_RepeatValidator('confirm_email'),
                    $mailvalid,
                    array('NotEmpty', 
                        true, 
                        array('messages' => array('isEmpty' => 'Empty'))
                    ), 
                    array('StringLength', 
                        false, 
                        array(6, 50, 'messages' => array('stringLengthTooShort' => 'E-MAIL TOO SHORT'))
                    ),
				))
				->setDecorators(array('CustomDecorator'));
				// ->removeDecorator('errors');
		
        $email_publicity = new Zend_Form_Element_Checkbox('email_publicity');
		$email_publicity->setDecorators(array('SettingsCheckboxDecorator'))
                ->setDescription($description); 
        
		// E-mail confirm input form element
		$confirm_email = new Zend_Form_Element_Text('confirm_email');
		$confirm_email->setLabel($translate->_("account-register-email_confirmation"))
				//->setRequired(true)
				->addFilter('StringtoLower')
				->addValidators(array(
                    $mailvalid,
                    array('NotEmpty', 
                        true, 
                        array('messages' => array('isEmpty' => 'Empty'))
                    ), 
                    array('StringLength', 
                        false, 
                        array(6, 50, 'messages' => array('stringLengthTooShort' => 'E-MAIL TOO SHORT'))
                    ),
				))
				->setDecorators(array('CustomDecorator'));				

				
		// Password input form element
		$password = new Zend_Form_Element_Password('password');
		$password->setLabel($translate->_("account-register-password"))
				//->setRequired(true)
				->addValidators(array(
				new Oibs_Validators_RepeatValidator('confirm_password'),
				array('NotEmpty', true, array('messages' => array('isEmpty' => 'Empty'))), 
				array('StringLength', false, array(4, 22, 'messages' => array('stringLengthTooShort' => 'PASSWORD TOO SHORT'))),
				))
				->setDecorators(array('CustomDecorator'));		
		
		// Password confirm input form element
		$password_confirm = new Zend_Form_Element_Password('confirm_password');
		$password_confirm->setLabel($translate->_("account-register-password_confirm"))
				//->setRequired(true)
				->addValidators(array(
				array('NotEmpty', true, array('messages' => array('isEmpty' => 'Empty'))), 
				array('StringLength', false, array(4, 22, 'messages' => array('stringLengthTooShort' => 'PASSWORD TOO SHORT'))),
				))
				->setDecorators(array('CustomDecorator'));
				
		// E-mail confirm input form element
		$current_password = new Zend_Form_Element_Password('current_password');
		$current_password->setLabel($translate->_("account-register-current_password"))
				->setRequired(true)
				->addValidators(array(
				new Oibs_Validators_CurrentPasswordValidator(),
				array('NotEmpty', true, array('messages' => array('isEmpty' => 'Empty'))), 
				))
				->setDecorators(array('CustomDecorator'));
		
		// Form submit buttom form element		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel($translate->_("account-register-submit"));
		
		// Add elements to form
		$this->setAttrib('enctype', 'multipart/form-data');
		$this->addElements(array(   $firstname, $firstname_publicity, 
                                    $surname, $surname_publicity, 
                                    $gender, $gender_publicity, 
                                    $profession, $profession_publicity, 
                                    $com, $com_publicity, 
                                    $country, $country_publicity, 
                                    $city, $city_publicity, 
                                    $birth, $birth_publicity, 
                                    $bio, $bio_publicity, 
                                    $phone, $phone_publicity, 
                                    // $openID, $openid_publicity, 
                                    $openID, /*$openid_publicity,*/
                                    $password, $password_confirm, 
                                    $email,
                                    $confirm_email, 
                                    $current_password, 
                                    $submit));
        
        // if you use try..catch Don't echo e!!
        }catch(Zend_Exception $e){echo '<pre>General error occurred! Please try again.';echo '</pre>';}
    }
	
    /*  What is this? Why is this here? Do we need it? Filename?? -Joel
	public function formRename($filename)
    {
            $path = $_SERVER['REQUEST_URI'];
            $id = basename($path);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            $newName = $id.'_photo.'.$ext;
            return $newName;
    }
    */
}