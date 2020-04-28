<?php
if (php_sapi_name() === 'cli' ) {
    require __DIR__.'/vendor/autoload.php';
    $noError = true;
    $dataFixturesDirectory = __DIR__.'\\src\\DataFixtures\\';
 
    foreach(['CustomerFixtures', 'RoomFixtures'] as $nameFixture) 
    {
        if(file_exists($dataFixturesDirectory.$nameFixture.'.php')) {
            $classe = '\\App\\DataFixtures\\'.$nameFixture;
            if(class_exists($classe) === false) {
                $noError = false;
                fwrite(STDOUT, "\n\033[31;47mFIXTURES Vous devez créer la classe \"".$nameFixture."\" avec le bon namespace ! \033[0m\n");
            } else {
                $fixtures = new $classe();
                if(method_exists($fixtures, 'load') === false) {
                    $noError = false;
                    fwrite(STDOUT, "\n\033[31;47mFIXTURES Vous devez créer la méthode \"load\" ! \033[0m\n");
                } else {
                    $fixtures->load();
                }
            }
        } else {
            $noError = false;
            fwrite(STDOUT, "\n\033[31;47mFIXTURES Le fichier \"".$dataFixturesDirectory.$nameFixture.".php\" ! \033[0m\n");
        }
    }
    if($noError) {
        fwrite(STDOUT, "\n\033[37;42mFIXTURES L'ensemble des fixtures ont été exécutés, lancez le test (fixtures) avec phpunit pour vérifier que votre code a fonctionné ! \033[0m\n");
    }
} else {
    die();
}
