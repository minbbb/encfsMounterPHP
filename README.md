# encfsMounterPHP
encfsMounterPHP allows you to mount and view the encFS directories via the web interface.
# How to install
1. Download and share on the site
2. In the "index.php" file in the "$decryptDirs" variable, specify the path to the decrypt folder (In most cases, in the default path, you will only need to change example.com to your domain, and DIR_WITH_THIS_SCRIPT to your directory where the script is located)
3. In the variable "$encryptDirs" you must specify the name (come up yourself) and the path to the encrypted directory
4. Profit
# Notes
If the directory is not unmounted after finishing the work with it, then after deleting your session this directory will remain mounted and will have to be unmounted manually
___________________
# encfsMounterPHP
encfsMounterPHP позволяет монтировать и просматривать encFS директории через веб интерфейс.
# Как установить
1. Загрузить и выложить на сайт
2. В файле "index.php" в переменной "$decryptDirs" указать путь до папки decrypt(В большинстве случаев в пути по умолчанию нужно будет изменить только example.com на свой домен, и DIR_WITH_THIS_SCRIPT на свою директорию где находится скрипт)
3. В переменной "$encryptDirs" указать имя(придумываете сами) и путь до зашифрованной директории
4. Profit
# Примечания
Если директорию не отмонтировать после окончания работы с ней, то после удаления вашей сессии эта директория останется смонтированной и придётся размонтировать вручную
# Screenshot
![alt-текст](https://github.com/minbbb/encfsMounterPHP/blob/master/screenshot.png "Screenshot")