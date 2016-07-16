<?php
return call_user_func(
    function () {
        $userCollection = new \Phalcon\Mvc\Micro\Collection();

        $userCollection
            ->setPrefix('/v1/phones2')
            ->setHandler('\App\Users\Controllers\PhonesController')
            ->setLazy(true);

        $userCollection->get('/', 'getPhones');
        $userCollection->get('/{id:\d+}', 'getPhone');

        $userCollection->post('/', 'addPhone');

        $userCollection->put('/{id:\d+}', 'editPhone');

        $userCollection->delete('/{id:\d+}', 'deletePhone');

        return $userCollection;
    }
);
