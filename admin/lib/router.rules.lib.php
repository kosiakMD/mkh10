<?php
/* Побудова роутера */
$Router = new Router();

/* Додавання правил */
$Router->add(array(
	'routeID' => 1,
	'url' => 'error/_404',
	'title' => 'Сторінка не знайдена | Помилка 404',
	'controller' => 'error',
	'action' => '_404',
	'privileges' => null
	)
);
$Router->add(array(
	'routeID' => 2,
	'url' => 'support',
	'title' => null,
	'controller' => 'manager',
	'action' => 'feedback',
	'privileges' => null
	)
);
$Router->add(array(
	'routeID' => 2,
	'url' => 'captcha(\?[0-9]+)?',
	'title' => null,
	'controller' => 'Kernel',
	'action' => 'captcha',
	'privileges' => null
	)
);
$Router->add(array(
	'routeID' => 2,
	'url' => 'user/auth',
	'title' => 'Вхід в систему',
	'controller' => 'user',
	'action' => 'auth',
	'privileges' => null
	)
);
$Router->add(array(
	'routeID' => 2,
	'url' => 'admin',
	'title' => 'Вхід в систему',
	'controller' => 'user',
	'action' => 'auth',
	'privileges' => null
	)
);
$Router->add(array(
	'routeID' => 3,
	'url' => 'user/signin',
	'title' => null,
	'controller' => 'user',
	'action' => 'signin',
	'privileges' => null
	)
);
$Router->add(array(
	'routeID' => 4,
	'url' => 'manager/user/signout',
	'title' => null,
	'controller' => 'user',
	'action' => 'signout',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 5,
	'url' => 'manager/user/ban/([0-9]+)',
	'title' => null,
	'controller' => 'user',
	'action' => 'ban',
	'privileges' => array(4)
	)
);
$Router->add(array(
	'routeID' => 6,
	'url' => 'manager/user/unban/([0-9]+)',
	'title' => null,
	'controller' => 'user',
	'action' => 'unban',
	'privileges' => array(4)
	)
);
$Router->add(array(
	'routeID' => 7,
	'url' => 'manager/user/privileges/([0-9]+)/([0-9]+)',
	'title' => null,
	'controller' => 'user',
	'action' => 'privileges',
	'privileges' => array(4)
	)
);
$Router->add(array(
	'routeID' => 7,
	'url' => 'manager/user/delete/([0-9]+)',
	'title' => null,
	'controller' => 'user',
	'action' => 'delete',
	'privileges' => array(4)
	)
);
$Router->add(array(
	'routeID' => 7,
	'url' => 'manager/user/messages',
	'title' => 'Панель керування | Особисті повідомлення',
	'controller' => 'manager',
	'action' => 'messages',
	'privileges' => array(4)
	)
);
$Router->add(array(
	'routeID' => 7,
	'url' => 'manager/user/messages/get',
	'title' => null,
	'controller' => 'manager',
	'action' => 'getmessages',
	'privileges' => array(4)
	)
);
$Router->add(array(
	'routeID' => 7,
	'url' => 'manager/user/messages/delete/([0-9]+)',
	'title' => null,
	'controller' => 'manager',
	'action' => 'deletemessage',
	'privileges' => array(4)
	)
);
$Router->add(array(
	'routeID' => 7,
	'url' => 'manager/user/create',
	'title' => null,
	'controller' => 'manager',
	'action' => 'createprofileform',
	'privileges' => array(4)
	)
);
$Router->add(array(
	'routeID' => 7,
	'url' => 'manager/user/save',
	'title' => null,
	'controller' => 'manager',
	'action' => 'usercreate',
	'privileges' => array(4)
	)
);
$Router->add(array(
	'routeID' => 7,
	'url' => 'manager/user/profile/save',
	'title' => null,
	'controller' => 'user',
	'action' => 'useredit',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 8,
	'url' => 'manager',
	'title' => 'Панель керування',
	'controller' => 'manager',
	'action' => 'main',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 9,
	'url' => 'manager/content',
	'title' => 'Панель керування | Список сторінок',
	'controller' => 'manager',
	'action' => 'pages',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 10,
	'url' => 'manager/content/create',
	'title' => 'Панель керування | Створення сторінки',
	'controller' => 'manager',
	'action' => 'pagecreate',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 10,
	'url' => 'manager/content/edit(/[0-9]+)?',
	'title' => 'Панель керування | Редактор контенту',
	'controller' => 'manager',
	'action' => 'pagecreate',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 10,
	'url' => 'manager/content/copy/([0-9]+)',
	'title' => null,
	'controller' => 'manager',
	'action' => 'pagecopy',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 13,
	'url' => 'manager/files/get/(.+)\~',
	'title' => null,
	'controller' => 'manager',
	'action' => 'get',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 11,
	'url' => 'manager/files/create/(file|dir)/query',
	'title' => null,
	'controller' => 'manager',
	'action' => 'createobject',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 11,
	'url' => 'manager/files/create/(file|dir)(.+)?',
	'title' => 'Панель керування | Файловий менеджер',
	'controller' => 'manager',
	'action' => 'createform',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 11,
	'url' => 'manager/files/delete/(.+)\~',
	'title' => null,
	'controller' => 'manager',
	'action' => 'deleteobject',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 12,
	'url' => 'manager/files/sum/(.+)\~',
	'title' => null,
	'controller' => 'manager',
	'action' => 'sum',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 11,
	'url' => 'manager/files/perms/set',
	'title' => null,
	'controller' => 'manager',
	'action' => 'setperms',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 14,
	'url' => 'manager/files/perms/(.+)\~',
	'title' => null,
	'controller' => 'manager',
	'action' => 'perms',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 11,
	'url' => 'manager/files(/.+)?',
	'title' => 'Панель керування | Файловий менеджер',
	'controller' => 'manager',
	'action' => 'files',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 15,
	'url' => 'manager/backup/db',
	'title' => 'Панель керування | Дамп бази даних',
	'controller' => 'manager',
	'action' => 'backup',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 16,
	'url' => 'manager/backup/db/get',
	'title' => null,
	'controller' => 'manager',
	'action' => 'getbackup',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 17,
	'url' => 'manager/backup/files',
	'title' => 'Панель керування | Резервна копія файлів',
	'controller' => 'manager',
	'action' => 'filebackup',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 17,
	'url' => 'manager/backup/files/create',
	'title' => null,
	'controller' => 'manager',
	'action' => 'createbackup',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 18,
	'url' => 'manager/users',
	'title' => 'Панель керування | Список користувачів',
	'controller' => 'manager',
	'action' => 'users',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 20,
	'url' => 'manager/upload/handler/(.+)?',
	'title' => 'Панель керування | Завантаження файлів ',
	'controller' => 'manager',
	'action' => 'uploadhandler',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 19,
	'url' => 'manager/upload(/.+)?',
	'title' => 'Панель керування | Завантаження файлів ',
	'controller' => 'manager',
	'action' => 'files',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 21,
	'url' => 'manager/content/save',
	'title' => null,
	'controller' => 'manager',
	'action' => 'savepage',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 21,
	'url' => 'manager/content/(on|off)/([0-9]+)',
	'title' => null,
	'controller' => 'manager',
	'action' => 'contentstatus',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 21,
	'url' => 'manager/content/delete/([0-9]+)',
	'title' => null,
	'controller' => 'manager',
	'action' => 'contentdelete',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 22,
	'url' => 'manager/categories',
	'title' => 'Панель керування | Список розділів',
	'controller' => 'manager',
	'action' => 'categories',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 23,
	'url' => 'manager/categories/create/save',
	'title' => null,
	'controller' => 'manager',
	'action' => 'savecategory',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 23,
	'url' => 'manager/categories/edit(/[0-9]+)?',
	'title' => null,
	'controller' => 'manager',
	'action' => 'createcategoryform',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 23,
	'url' => 'manager/categories/delete(/[0-9]+)?',
	'title' => null,
	'controller' => 'manager',
	'action' => 'deletecategory',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 23,
	'url' => 'manager/categories/clear(/[0-9]+)?',
	'title' => null,
	'controller' => 'manager',
	'action' => 'clearcategory',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 24,
	'url' => 'manager/profile/get',
	'title' => null,
	'controller' => 'manager',
	'action' => 'getprofile',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 25,
	'url' => 'manager/content/([0-9]+)',
	'title' => null,
	'controller' => 'manager',
	'action' => 'generatepage',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 26,
	'url' => 'manager/navigation',
	'title' => 'Панель керування | Навігація',
	'controller' => 'manager',
	'action' => 'navigation',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 26,
	'url' => 'manager/navigation/edit(/[0-9]+)?',
	'title' => null,
	'controller' => 'manager',
	'action' => 'navigationeditform',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 26,
	'url' => 'manager/navigation/save',
	'title' => null,
	'controller' => 'manager',
	'action' => 'navigationedit',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 26,
	'url' => 'manager/navigation/delete/([0-9]+)',
	'title' => null,
	'controller' => 'manager',
	'action' => 'navigationdelete',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 26,
	'url' => 'manager/navigation/(on|off)/([0-9]+)',
	'title' => null,
	'controller' => 'manager',
	'action' => 'navigationstatus',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 27,
	'url' => 'site/stats',
	'title' => null,
	'controller' => 'manager',
	'action' => 'getvisits',
	'privileges' => null
	)
);
$Router->add(array(
	'routeID' => 28,
	'url' => 'manager/stats',
	'title' => 'Панель керування | Статистика',
	'controller' => 'manager',
	'action' => 'stats',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 27,
	'url' => 'manager/stats/get',
	'title' => null,
	'controller' => 'manager',
	'action' => 'getvisits',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 29,
	'url' => 'manager/logs',
	'title' => 'Панель керування | Журнал подій',
	'controller' => 'manager',
	'action' => 'logs',
	'privileges' => array(4)
	)
);
$Router->add(array(
	'routeID' => 29,
	'url' => 'manager/logs/clear',
	'title' => null,
	'controller' => 'manager',
	'action' => 'clearlogs',
	'privileges' => array(4)
	)
);
$Router->add(array(
	'routeID' => 30,
	'url' => 'manager/system',
	'title' => 'Панель керування | Інформація про систему',
	'controller' => 'manager',
	'action' => 'main',
	'privileges' => array(4)
	)
);
$Router->add(array(
	'routeID' => 31,
	'url' => 'manager/events',
	'title' => 'Панель керування | Редактор подій',
	'controller' => 'manager',
	'action' => 'events',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 31,
	'url' => 'manager/events/edit(/[0-9]+)?',
	'title' => null,
	'controller' => 'manager',
	'action' => 'addeventsform',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 31,
	'url' => 'manager/events/save',
	'title' => null,
	'controller' => 'manager',
	'action' => 'saveevent',
	'privileges' => array(1,2,3,4)
	)
);
$Router->add(array(
	'routeID' => 31,
	'url' => 'manager/events/delete/([0-9]+)',
	'title' => null,
	'controller' => 'manager',
	'action' => 'deleteevent',
	'privileges' => array(1,2,3,4)
	)
);

/* Сайт 50 - 99 */
$Router->add(array(
	'routeID' => 50,
	'url' => 'site/content/([a-z0-9\_]+)',
	'title' => null,
	'controller' => 'site',
	'action' => 'page',
	'privileges' => null
	)
);
$Router->add(array(
	'routeID' => 50,
	'url' => 'site/content/([0-9]+)',
	'title' => null,
	'controller' => 'site',
	'action' => 'page',
	'privileges' => null
	)
);


$Router->add(array(
	'routeID' => 100,
	'url' => 'manager/icd10',
	'title' => "МКХ-10 - База Даних",
	'controller' => 'icd10',
	'action' => 'main',
	'privileges' => array(4)
	)
);
$Router->add(array(
	'routeID' => 101,
	'url' => 'manager/icd10?type=class',
	'title' => "МКХ-10 - База Даних",
	'controller' => 'icd10',
	'action' => 'main',
	'privileges' => array(4)
	)
);
$Router->add(array(
	'routeID' => 102,
	'url' => 'manager/icd10?type=block',
	'title' => "МКХ-10 - База Даних",
	'controller' => 'icd10',
	'action' => 'main',
	'privileges' => array(4)
	)
);
$Router->add(array(
	'routeID' => 103,
	'url' => 'manager/icd10?type=nosology',
	'title' => "МКХ-10 - База Даних",
	'controller' => 'icd10',
	'action' => 'main',
	'privileges' => array(4)
	)
);
$Router->add(array(
	'routeID' => 104,
	'url' => 'manager/icd10?type=diagnos',
	'title' => "МКХ-10 - База Даних",
	'controller' => 'icd10',
	'action' => 'main',
	'privileges' => array(4)
	)
);
/* Отримання сторінки */
$Router->get();

/* Закриття роутера і очистка пам'яті */
$Router->destroy();
?>