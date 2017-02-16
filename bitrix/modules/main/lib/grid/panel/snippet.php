<?

namespace Bitrix\Main\Grid\Panel;


use Bitrix\Main\Grid\Panel\Snippet\Button;
use Bitrix\Main\Grid\Panel\Snippet\Onchange;


class Snippet
{
	protected $applyButton;
	protected $saveButton;
	protected $cancelButton;
	protected $editButton;
	protected $removeButton;
	protected $saveAndCancelButtons;


	public function getSaveEditButton()
	{
		if (!is_array($this->saveButton))
		{
			$onchange = new Onchange();
			$onchange->addAction(array("ACTION" => Actions::SHOW_ALL, "DATA" => array()));
			$onchange->addAction(array("ACTION" => Actions::CALLBACK, "DATA" => array(array("JS" => "Grid.editSelectedSave()"))));
			$onchange->addAction(array("ACTION" => Actions::REMOVE, "DATA" => array(array("ID" => DefaultValue::SAVE_BUTTON_ID), array("ID" => DefaultValue::CANCEL_BUTTON_ID))));

			$saveButton = new Button();
			$saveButton->setClass(DefaultValue::SAVE_BUTTON_CLASS);
			$saveButton->setText(DefaultValue::SAVE_BUTTON_TEXT);
			$saveButton->setId(DefaultValue::SAVE_BUTTON_ID);
			$saveButton->setOnchange($onchange);

			$this->saveButton = $saveButton->toArray();
		}

		return $this->saveButton;
	}

	public function getCancelEditButton()
	{
		if (!is_array($this->cancelButton))
		{
			$onchange = new Onchange();
			$onchange->addAction(array("ACTION" => Actions::SHOW_ALL, "DATA" => array()));
			$onchange->addAction(array("ACTION" => Actions::CALLBACK, "DATA" => array(array("JS" => "Grid.editSelectedCancel()"))));
			$onchange->addAction(array("ACTION" => Actions::REMOVE, "DATA" => array(array("ID" => DefaultValue::SAVE_BUTTON_ID), array("ID" => DefaultValue::CANCEL_BUTTON_ID))));

			$cancelButton = new Button();
			$cancelButton->setClass(DefaultValue::CANCEL_BUTTON_CLASS);
			$cancelButton->setText(DefaultValue::CANCEL_BUTTON_TEXT);
			$cancelButton->setId(DefaultValue::CANCEL_BUTTON_ID);
			$cancelButton->setOnchange($onchange);

			$this->cancelButton = $cancelButton->toArray();
		}

		return $this->cancelButton;
	}

	public function getEditButton()
	{
		if (!is_array($this->editButton))
		{
			$onchange = new Onchange();
			$onchange->addAction(array("ACTION" => Actions::CREATE, "DATA" => array($this->getSaveEditButton(), $this->getCancelEditButton())));
			$onchange->addAction(array("ACTION" => Actions::CALLBACK, "DATA" => array(array("JS" => "Grid.editSelected()"))));
			$onchange->addAction(array("ACTION" => Actions::HIDE_ALL_EXPECT, "DATA" => array(array("ID" => DefaultValue::SAVE_BUTTON_ID), array("ID" => DefaultValue::CANCEL_BUTTON_ID))));

			$editButton = new Button();
			$editButton->setClass(DefaultValue::EDIT_BUTTON_CLASS);
			$editButton->setId(DefaultValue::EDIT_BUTTON_ID);
			$editButton->setOnchange($onchange);

			$this->editButton = $editButton->toArray();
		}

		return $this->editButton;
	}

	public function getRemoveButton()
	{
		if (!is_array($this->removeButton))
		{
			$onchange = new Onchange();
			$onchange->addAction(array("ACTION" => Actions::CALLBACK, "DATA" => array(array("JS" => "Grid.removeSelected()"))));

			$removeButton = new Button();
			$removeButton->setClass(DefaultValue::REMOVE_BUTTON_CLASS);
			$removeButton->setId(DefaultValue::REMOVE_BUTTON_ID);
			$removeButton->setOnchange($onchange);

			$this->removeButton = $removeButton->toArray();
		}

		return $this->removeButton;
	}

}