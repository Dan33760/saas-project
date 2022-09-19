<?php

# Genereer Un Code Shopping Cart
if(!function_exists('new_shop_cart_code')) {
    function new_shop_cart_code()
    {
        $aleatCode = Str::random(4);
        $code = 'SC'.(time() - 1662710000).''.$aleatCode;

        return $code;
    }
}

# Genereer Un Code User
if(!function_exists('generate_user_code')) {
    function generate_user_code()
    {
        $codeAleatoire = Str::upper(Str::random(4));
        $code = 'FY'.(time() - 1662710000).''.$codeAleatoire;

        return $code;
    }
}

# Genereer Un Code User
if(!function_exists('generate_store_code')) {
    function generate_store_code($store)
    {
        $index = Str::remove('.',Str::limit($store, 2));
        $aleatCode = Str::random(4);
        $code = Str::upper($index).(time() - 1662710000).''.$aleatCode;

        return $code;
    }
}