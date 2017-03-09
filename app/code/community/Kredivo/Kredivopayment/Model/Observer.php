<?php
/**
 * NOTICE OF LICENSE
 *
 * @category    Kredivo
 * @package     Kredivo_Kredivopayment
 * @author      Kredivo.
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Kredivo_Kredivopayment_Model_Observer
{
    public function disableMethod(Varien_Event_Observer $observer)
    {
        $moduleName = "Kredivo_Kredivopayment";
        if ('kredivopayment' == $observer->getMethodInstance()->getCode()) {
            if (!Mage::getStoreConfigFlag('advanced/modules_disable_output/' . $moduleName)) {
                //nothing here, as module is ENABLE
            } else {
                $observer->getResult()->isAvailable = false;
            }

        }
    }

    public function filterPaymentMethod(Varien_Event_Observer $observer)
    {
      $quote = $observer->getQuote();
      $method = $observer->getEvent()->getMethodInstance();
      if ($quote) {
        $subtotal = (int) $quote->getSubtotal();
      }
      $result = $observer->getEvent()->getResult();

      $payment_code = $method->getCode();

      if ($payment_code =='kredivopayment') {
        if ($subtotal >= 1990000):
          $result->isAvailable = false;
        endif;
      }
    }
}
