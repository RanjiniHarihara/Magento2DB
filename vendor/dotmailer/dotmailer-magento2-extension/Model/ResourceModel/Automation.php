<?php

namespace Dotdigitalgroup\Email\Model\ResourceModel;

class Automation extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @var \Dotdigitalgroup\Email\Helper\Data
     */
    public $helper;

    /**
     * Initialize resource.
     *
     * @return null
     */
    public function _construct()
    {
        $this->_init('email_automation', 'id');
    }

    /**
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param \Dotdigitalgroup\Email\Helper\Data $data
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        \Dotdigitalgroup\Email\Helper\Data $data
    ) {
        $this->helper = $data;
        parent::__construct($context);
    }

    /**
     * update status for automation entries
     *
     * @param array $contactIds
     * @param string $status
     * @param string $message
     * @param mixed $updatedAt
     * @param string $type
     *
     * @return null
     */
    public function updateStatus($contactIds, $status, $message, $updatedAt, $type)
    {
        $conn = $this->getConnection();
        $bind = [
            'enrolment_status' => $status,
            'message' => $message,
            'updated_at' => $updatedAt,
        ];
        $where = ['id IN(?)' => $contactIds];
        $num = $conn->update(
            $conn->getTableName('email_automation'),
            $bind,
            $where
        );
        //number of updated records
        if ($num) {
            $this->helper->log(
                'Automation type : ' . $type . ', updated : ' . $num
            );
        }
    }
}