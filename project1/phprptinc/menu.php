<?php

/**
 * Menu class
 */

class cMenu {
	var $Id;
	var $IsRoot = FALSE;
	var $ItemData = array();
	var $NoItem = NULL;

	function cMenu($id) {
		$this->Id = $id;
	}

	// Add a menu item
	function AddMenuItem($id, $text, $url, $parentid, $allowed = TRUE) {
		$item = new cMenuItem($id, $text, $url, $parentid, $allowed);
		if (!MenuItem_Adding($item)) return;
		if ($item->ParentId < 0) {
			$this->AddItem($item);
		} else {
			if ($oParentMenu =& $this->FindItem($item->ParentId))
				$oParentMenu->AddItem($item);
		}
	}

	// Add item to internal array
	function AddItem($item) {
		$this->ItemData[] = $item;
	}

	// Find item
	function &FindItem($id) {
		$cnt = count($this->ItemData);
		for ($i = 0; $i < $cnt; $i++) {
			$item =& $this->ItemData[$i];
			if ($item->Id == $id) {
				return $item;
			} elseif (!is_null($item->SubMenu)) {
				if ($subitem = $item->SubMenu->FindItem($id))
					return $subitem;
			}
		}
		return $this->NoItem;
	}

	// Check if a menu item should be shown
	function RenderItem($item) {
		if (!is_null($item->SubMenu)) {
			foreach ($item->SubMenu->ItemData as $subitem) {
				if ($item->SubMenu->RenderItem($subitem))
					return TRUE;
			}
		}
		return ($item->Allowed && $item->Url <> "");
	}

	// Check if this menu should be rendered
	function RenderMenu() {
		foreach ($this->ItemData as $item) {
			if ($this->RenderItem($item))
				return TRUE;
		}
		return FALSE;
	}

	// Render the menu
	function Render() {
		if (!$this->RenderMenu())
			return;
		echo "<ul";
		if ($this->Id <> "") {
			if (is_numeric($this->Id)) {
				echo " id=\"menu_" . $this->Id . "\"";
			} else {
				echo " id=\"" . $this->Id . "\"";
			}
		}
		if ($this->IsRoot)
			echo " class=\"" . EW_REPORT_MENUBAR_VERTICAL_CLASSNAME . "\"";
		echo ">\n";
		foreach ($this->ItemData as $item) {
			if ($this->RenderItem($item)) {
				echo "<li><a";
				if (!is_null($item->SubMenu) && $item->SubMenu->RenderMenu())
					echo " class=\"" . EW_REPORT_MENUBAR_SUBMENU_CLASSNAME . "\"";
				if ($item->Url <> "")
					echo " href=\"" . htmlspecialchars(strval($item->Url)) . "\"";
				echo ">" . $item->Text . "</a>\n";
				if (!is_null($item->SubMenu))
					$item->SubMenu->Render();
				echo "</li>\n";
			}
		}
		echo "</ul>\n";
	}
}

// Menu item class
class cMenuItem {
	var $Id;
	var $Text;
	var $Url;
	var $ParentId;
	var $SubMenu = NULL; // Data type = cMenu
	var $Allowed = TRUE;

	function cMenuItem($id, $text, $url, $parentid, $allowed) {
		$this->Id = $id;
		$this->Text = $text;
		$this->Url = $url;
		$this->ParentId = $parentid;
		$this->Allowed = $allowed;
	}

	function AddItem($item) { // Add submenu item
		if (is_null($this->SubMenu))
			$this->SubMenu = new cMenu($this->Id);
		$this->SubMenu->AddItem($item);
	}
}

// Menu item adding
function MenuItem_Adding(&$Item) {

	//var_dump($Item);
	// Return FALSE if menu item not allowed

	return TRUE;
}
?>
<!-- Begin Main Menu -->
<div class="phpreportmaker">
<?php

// Generate all menu items
$RootMenu = new cMenu("RootMenu");
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(7, "CATEMPLEADO", "CATEMPLEADOrpt.php", -1, TRUE);
$RootMenu->AddMenuItem(13, "CATPRODUCTO", "CATPRODUCTOrpt.php", -1, TRUE);
$RootMenu->AddMenuItem(16, "CATSUCURSAL", "CATSUCURSALrpt.php", -1, TRUE);
$RootMenu->AddMenuItem(21, "CATVENDEDOR PROV", "CATVENDEDOR_PROVrpt.php", -1, TRUE);
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->
