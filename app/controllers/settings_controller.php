<?php
class SettingsController extends AppController {
	public $name = 'Settings';
    public $helpers = array('Form', 'Html', 'Js', 'Time', 'Ajax');
	public $components = array('RequestHandler','Validation','Session');

	function index() {
		$this->set('title_for_layout', 'Setting');
	}

	/**
	* querying to get list of web settings
	* @return void
	* @public
	**/
	function admin_index()
	{
		$this->setTitle('Settings');
		// set raw data settings...
		$setting = $this->Setting->find('all' , array(
			'order' => array('Setting.id')
		));

		$this->set('lastModified' , $setting[12]['Setting']['value']);
		$myEditor = $this->User->findById($setting[13]['Setting']['value']);
		$this->set('myEditor' , $myEditor);

		// for image input type reason...
		$myImageTypeList = $this->EntryMeta->embedded_img_meta('type');
		$this->set('myImageTypeList' , $myImageTypeList);

		// if form submit is taken...
		if(!empty($this->data))
		{
			// SPECIAL CASE FOR CHECKBOX CROPPING IMAGE DATA...
			$this->data['Setting'][17]['value'] = (empty($this->data['Setting'][17]['value'])?0:$this->data['Setting'][17]['value']);
			$this->data['Setting'][20]['value'] = (empty($this->data['Setting'][20]['value'])?0:$this->data['Setting'][20]['value']);
			$store_format = $this->Setting->findByKey("store_format");
			if (!empty($store_format))
				$this->data['Setting'][28]['value'] = (empty($this->data['Setting'][28]['value'])?0:$this->data['Setting'][28]['value']);

			// VALIDATION BEGINSSS...
			$myDetails = $this->data['Setting'];
			foreach ($myDetails as $key => $value)
			{
				// checking validation from view layout !!!
				$myValid = explode('|', $value['validation']);
				foreach ($myValid as $key10 => $value10)
				{
					if(!$this->Validation->blazeValidate($value['value'],$value10))
					{
						$this->Session->setFlash('Update failed. Please try again','failed');
						$this->redirect('/admin/settings');
					}
				}
			}

			// UPDATE LANGUAGE SETTING FIRST !!
			if(!empty($myDetails[21]['multilanguage']))
			{
				foreach ($myDetails[21]['optlang'] as $key => $value)
				{
					$myDetails[21]['value'] .= chr(13).chr(10).$key;
				}
			}
			// NOW SAVE THE SETTINGS ...
			foreach ($myDetails as $key => $value)
			{
				$this->Setting->id = $key+1;
				$this->Setting->saveField('value' , $value['value']);
			}
			// save modified !!
			$myCreator = $this->Auth->user();
			$this->Setting->id = 13;
			$this->Setting->saveField('value' , $this->getNowDate());
			$this->Setting->id = 14;
			$this->Setting->saveField('value' , $myCreator['Account']['user_id']);

			// DELETE LANGUAGE WHICH IS ALREADY NOT IN USE !!
			$this->del_lang($setting[21]['Setting']['value'], $myDetails[21]['value']);

			// FINALLY SET FLASH !!
			$this->Session->setFlash('Settings has been updated.','success');
			//header("Location: ".$_SESSION['now']);
			$this->redirect('/admin/settings');
		}
	}

	function del_lang($src , $dst)
	{
		$temp = explode(chr(13).chr(10), $src);
		foreach ($temp as $key => $value)
		{
			if(strpos($dst, $value) === FALSE)
			{
				$this->Entry->updateAll(
					array('Entry.status' => "'-1'"),
					array('Entry.lang_code LIKE' => substr($value, 0,2).'-%')
				);
			}
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid setting', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('setting', $this->Setting->read(null, $id));
	}

	/**
	* add new additional info settings
	* @return void
	* @public
	**/
	function add()
	{
		$this->autoRender = FALSE;
		$this->data['Setting']['name'] = 'info';
		$this->data['Setting']['key'] = strtolower(Inflector::slug($this->params['form']['key']));
		$this->data['Setting']['value'] = '';
		$this->Setting->create();
		$this->Setting->save($this->data);

		// prepare data for js callback...
		$this->data['Setting']['counter'] = $this->Setting->id - 1;
		$this->data['Setting']['slug_key'] = string_unslug($this->data['Setting']['key']);
		echo json_encode($this->data['Setting']);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid setting', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Setting->save($this->data)) {
				$this->Session->setFlash(__('The setting has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The setting could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Setting->read(null, $id);
		}
		$media = $this->Setting->Media->find('list');
		$this->set(compact('media'));
	}

	/**
	* delete record settings
	* @param integer $id contains id of the settings
	* @return void
	* @public
	**/
	function delete($id)
	{
		$this->autoRender = FALSE;
		$this->Setting->delete($id);
	}
}
