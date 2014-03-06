<?php
/**
 * Vehicle Fits (http://www.vehiclefits.com for more information.)
 * @copyright  Copyright (c) Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class VF_Note_Catalog_Product extends VF_Base
{
    /** @var VF_Product */
    protected $wrappedProduct;

    function __construct(VF_Schema $schema, Zend_Db_Adapter_Abstract $adapter, Zend_Config $config, VF_Product $productToWrap)
    {
        parent::__construct($schema, $adapter, $config);
        $this->wrappedProduct = $productToWrap;
    }

    function addNote(VF_Vehicle $vehicle, $noteCode)
    {
        $mappingId = $this->getMappingId($vehicle);
        $note = $this->noteFinder()->findByCode($noteCode);
        $this->noteFinder()->insertNoteRelationship($mappingId, $note->id);
    }

    function numberOfNotes(VF_Vehicle $vehicle)
    {
        return count($this->notes($vehicle));
    }

    function notesCodes(VF_Vehicle $vehicle)
    {
        $codes = array();
        foreach ($this->notes($vehicle) as $note) {
            $codes[] = $note->code;
        }
        return $codes;
    }

    function notes(VF_Vehicle $vehicle)
    {
        $mappingId = $this->getMappingId($vehicle);
        return $this->noteFinder()->getNotes($mappingId);
    }

    function noteFinder()
    {
        return new VF_Note_Finder($this->getReadAdapter());
    }

    function __call($methodName, $arguments)
    {
        $method = array($this->wrappedProduct, $methodName);
        return call_user_func_array($method, $arguments);
    }
}