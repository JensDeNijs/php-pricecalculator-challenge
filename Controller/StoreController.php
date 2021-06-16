<?php
declare(strict_types=1);

class StoreController
{


    public function render(array $GET, array $POST)
    {
        $loader = new ProductLoader();
        $allProducts = $loader->getAllProducts();

        $loader2 = new CustomerLoader();
        $allCustomers = $loader2->getAllCustomers();

        $loader3 = new CustomerGroupLoader();
        $allCustomerGroups = $loader3->getAllCustomerGroups();


        if (isset($_POST["customer"])) {
            $customer = $loader2->getCustomerById((int)$_POST["customer"]);

            $customerName = $customer->getFirstName();
            $customerLastName = $customer->getLastName();
            $customerGroup = $customer->getGroupId();
            $customerFixed = $customer->getFixedDiscount();
            $customerVariable = $customer->getVariableDiscount();

            $group = $loader3->getGroupById((int)$customerGroup);
            $groupFixed = array($group->getFixedDiscount());
            $groupVariable = array($group->getVariableDiscount());
            $groupParent = $group->getParentId();

            while ($groupParent > 0) {
                $group = $loader3->getGroupById((int)$groupParent);
                $fix = $group->getFixedDiscount();
                if (isset($fix)) {
                    array_push($groupFixed, $group->getFixedDiscount());
                }
                $var = $group->getVariableDiscount();
                if (isset($var)) {
                    array_push($groupVariable, $group->getVariableDiscount());
                }
                $groupParent = $group->getParentId();
            }

            echo "Name:<br>";
            echo $customerName . " " . $customerLastName;
            echo '<br><br>';
            echo "FixedDiscount:<br>";
            echo $customerFixed;
            echo '<br><br>';
            echo "VariableDiscount:<br>";
            echo $customerVariable;
            echo '<br><br>';
            echo "FixedGroupDiscounts: <br>";
            var_dump($groupFixed);
            echo '<br><br>';
            echo "VariableGroupDiscounts: <br>";
            var_dump($groupVariable);
            echo '<br>';
            echo '<br>';

        }


        require 'View/store.php';
    }
}
