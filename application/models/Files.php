<?php
/**
 *  Files -> Files database model for content files table.
 *
* 	Copyright (c) <2009>, Markus Riihel�
* 	Copyright (c) <2009>, Mikko Sallinen
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
 *  Files - class
 *
 *  @package 	models
 *  @author 		Markus Riihel� & Mikko Sallinen
 *  @copyright 	2009 Markus Riihel� & Mikko Sallinen
 *  @license 	GPL v2
 *  @version 	1.0
 */ 
class Default_Model_Files extends Zend_Db_Table_Abstract
{
	// Table name
    protected $_name = 'files_fil';
    
	// Table primary key
	protected $_primary = 'id_fil';
	
	// Table reference map
	protected $_referenceMap    = array(
        'FileContent' => array(
            'columns'           => array('id_cnt_fil'),
            'refTableClass'     => 'Default_Model_Content',
            'refColumns'        => array('id_cnt')
        ),
		'FileUser' => array(
			'columns'			=> array('id_usr_fil'),
			'refTableClass'		=> 'Default_Model_User',
			'refColumns'		=> array('id_usr')
		)
    );
    
    /**
    *   newUserImage > set new user image to default, used in registration
    *   
    *   @param  id_cnt		int		content id with which the file is linked 
    *   @param  id_usr      int     user id for the user whose pic to modify
    *   @param  uploadedFile array  has info of file, if left empty will use $_FILES 
    *   @return success boolean was the procedure succesful?
    */
    public function newFile($id_cnt, $id_usr, $uploadedFile = "") 
    {
    	if ($uploadedFile == "") {
    		$uploadedFile = $_FILES['content_file_upload'];
    	}
    	
        // $path was replaced by $_FILES['image']['tmp_name']
		//$thumbdata = fopen($_FILES['image']['tmp_name'], 'r');
		//$thumbnail = fread($thumbdata, filesize($_FILES['image']['tmp_name']));

        // Read fullsized file info location relates to index.php bootstrap loader
        $fullsizedata = fopen($uploadedFile['tmp_name'], 'r');
        $fullsize = fread($fullsizedata, filesize($uploadedFile['tmp_name']));

        // generate new row
        $file = $this->createRow();
        // Set images and user id
        $file->id_cnt_fil = $id_cnt;
        $file->id_usr_fil = $id_usr;
        $file->filename_fil = $uploadedFile['name'];
        $file->filesize_fil = $uploadedFile['size'];
        $file->data_fil = $fullsize;
        $file->filetype_fil = $uploadedFile['type'];

        $file->created_fil = new Zend_Db_Expr('NOW()');
        $file->modified_fil = new Zend_Db_Expr('NOW()');
        
        
        $file->save();
    }
    
    public function getFilenamesByCntId($id_cnt){
    	$select = $this->select()
    				   ->from($this, array('id_fil', 'filename_fil'))
    				   ->where('id_cnt_fil = ?', $id_cnt);
    	$result = $this->fetchAll($select);
    	$rows = array();
    	foreach ($result as $row) {
    		$rows[$row->id_fil] = $row->filename_fil;
    	}
		return $rows;
    }
    
    public function getFileData($id_fil = 0)
    {
        // Get file data        
        if ($id_fil != 0) {
        
            // Create query
            $select = $this->_db->select()
                                ->from('files_fil', 
                                       array('data_fil', 'filetype_fil'))
                                ->where('id_fil = ?', $id_fil);
            
            // Fetch data from database
            $result = $this->_db->fetchAll($select);
            
            return $result;
        }
    }
    
    public function deleteFiles($files) {
    	foreach ($files as $file) {
    		$this->delete('id_fil = ' . $file);
    	}
    	
    	
    	//$usrhasntf->delete('id_usr = '.$userId);
    }
    
    /**
    *   fileExists
    *
    *   Check if file exists in database.
    *
    *   @param $id_fil integer Id of file
    *   @return boolean
    */
    public function fileExists($id_fil = 0)
    {
        $exists = false;
        
        if ($id_fil != 0) {
            $select = $this->select()
                            ->from($this, array('filename_fil'))
                            ->where('id_fil = ?', $id_fil);
            
            $result = $this->fetchAll($select)->toArray();
            
            if(isset($result[0]) && !empty($result[0])) {
                $exists = true;
            }
        }
        
        return $exists;
    }

    /**
    *   removeContentFiles
    *   Removes specified file
    *
    *   @param		int		id_cnt_fil	Id of the content
    *   @author		Mikko Korpinen
    */
    public function removeContentFiles($id_cnt_fil)
    {
        $where = $this->getAdapter()->quoteInto('id_cnt_fil = ?', $id_cnt_fil);
        if ($this->delete($where)) {
            return true;
        } else {
            return false;
        }
    }

} // end of class
?>