<?php

namespace app\controllers;

use app\models\Event;
use app\models\EventUsers;
use app\models\Login;
use app\models\Role;
use app\models\Permission;
use app\models\Users;
use app\models\UsersSearch;
use Yii;
use app\models\Signup;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class EventerController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
//                'only' => ['logout', 'login', 'signup','about'],
                'rules' => [
                    [
                        'actions' => ['login', 'signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => [
                            'logout',
                            'index',
                            'show-profile',
                            'recovery',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'ban',
                            'invite',
                        ],
                        'matchCallback' => function () {
                            return in_array(Yii::$app->user->identity->role_id, [
                                Role::ROLE_ADMIN,
                                Role::ROLE_ORG,
                            ]);
                        },
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'add-user',
                            'delete-user',
                            'add-org',
                            'delete-org',
                            'update-profile',
                        ],
                        'matchCallback' => function () {
                            return in_array(Yii::$app->user->identity->role_id, [
                                Role::ROLE_ADMIN,
                            ]);
                        },
                    ],
                ]
            ]
        ];
    }

    public function actionIndex()
    {
        //проверяем залогинен или нет
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }
        //получаем данные о текущем юзере
        $resUsers = Yii::$app->user->identity->role->permission; //правильный массив выводит только доступные для этой роли права и маршруты

//        echo '<pre>';
//        var_dump($resUsers); die();

        return $this->render('index', compact('resUsers'));
    }

    public function actionSignup()
    {
        $model = new Signup();

        if (Yii::$app->request->post('Signup')) {
            $model->attributes = Yii::$app->request->post('Signup');
            if ($model->validate() && $model->signup()) {
                return $this->actionIndex();
            }
        }

        return $this->render('signup', ['model' => $model]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->actionIndex();
        }

        $login_model = new Login();

        if (Yii::$app->request->post('Login')) {
            $login_model->attributes = Yii::$app->request->post('Login');
            if ($login_model->validate()) {
                Yii::$app->user->login($login_model->getUser());
                return $this->actionIndex();
            }
        }

        return $this->render('login', ['login_model' => $login_model]);
    }

    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
            return $this->redirect(['login']);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    /////////////////////////////////////////////////////////////////
    //страницы действий на которые перенаправит юзера

    public function actionShowProfile()
    {
        $user = Yii::$app->user->identity;
        return $this->render('show-profile', compact('user'));
    }

    public function actionRecovery()
    {
        if (Yii::$app->request->post()) {
            $user = Users::findModelByEmail($this->request->post('Users')['email']);
            if (!empty($user)) {
                $params = $this->sendAndConfirmNotification($this->request->post());
                if ($user->load($params) && $user->save()) {
                    return $this->render('show-profile', compact('user'));
                }
            }
        }
        $model = new Users();
        return $this->render('recovery', ['model' => $model]);
    }

    public function sendAndConfirmNotification($post)
    {
        // отправил на почту и получил подтверждение
        return $post;
    }

    public function actionBan()
    {
        if (!empty($this->request->post('Users')['email'])) {
            $euModel = EventUsers::find();
            $euModel->select('{{event_users}}.users_id, {{event_users}}.event_id, {{event_users}}.ban');
            $euModel->leftJoin('{{users}}', '{{event_users}}.users_id = {{users}}.id');
            $euModel->addSelect('{{users}}.email, {{users}}.id');
            $euModel->andWhere(['{{users}}.email' => $this->request->post('Users')['email']]);
            if (!empty($this->request->post('Event')['id']) && !in_array(-1, $this->request->post('Event')['id'])) {
                $euModel->leftJoin('{{event}}', '{{event_users}}.event_id = {{event}}.id');
//                $euModel->addSelect('{{event}}.title, {{event}}.id AS event_idiii');
                $euModel->andWhere(['{{event}}.id' => $this->request->post('Event')['id']]);
            }
            foreach ($euModel->all() as $item) {
                $item->ban = true;
                $item->save();
            }
        }
        $modelUsers = new Users();
        $modelEvent = new Event();
        return $this->render('ban', ['modelUsers' => $modelUsers, 'modelEvent' => $modelEvent]);
    }

    public function actionInvite()
    {
        $currentUser = Yii::$app->user->identity;
        $alert = '';

        if (!empty($this->request->post('Users')['name'])
            && !empty($this->request->post('Users')['email'])
            && !empty($this->request->post('Event')['id'])) {

            $successSend = $this->sendInvite(
                $this->request->post('Users')['name'],
                $this->request->post('Users')['email'],
                $this->request->post('Event')['id']
            );

            $alert = $successSend ? 'Приглос успешно отправлен' . $this->request->post('Users')['email'] : '';
        }

        $query = Event::find();
        $query->select('{{event}}.id, {{event}}.title');
        $query->leftJoin('{{event_users}}', '{{event}}.id = {{event_users}}.event_id');
        $query->andWhere(['{{event_users}}.users_id' => $currentUser->getId()]);
        $query->andWhere(['{{event_users}}.org' => true]);
        $model = $query->asArray()->all();

        $itemsModel = ArrayHelper::map($model, 'id', 'title');

        $modelUsers = new Users();
        $modelEvent = new Event();
        return $this->render('invite',
            [
                'itemsModel'  => $itemsModel,
                'modelUsers'  => $modelUsers,
                'modelEvent'  => $modelEvent,
                'alert'       => $alert
            ]);
    }

    public function sendInvite($name,$email,$event_id)
    {
        $eventTitle = Event::findOne($event_id)->title;
        // отправил на почту и получил подтверждение
        $text = "Уважаемый, $name, приглашаю Вас на мероприятие $eventTitle";
        $recipient = $email;
        //типа если успешно отправилось возвращаем успешный успех
        return !empty($text) && !empty($recipient);
    }

    public function actionAddUser()
    {
        $currentUser = Yii::$app->user->identity;

        if (!empty($this->request->post('Users')['name'])
            && !empty($this->request->post('Users')['email'])
            && !empty($this->request->post('Users')['password'])) {

            $newUser = new Users();

            $newUser->setAttributes(
                [
                    'name' => $this->request->post('Users')['name'],
                    'email' => $this->request->post('Users')['email'],
                    'password' => $this->request->post('Users')['password'],
                ]);

            $newUser->save();
        }
        $modelUsers = new Users();
        return $this->render('add-user',
            [
                'currentUser' => $currentUser,
                'modelUsers'  => $modelUsers,
            ]);
    }

    public function actionDeleteUser()
    {
        $currentUser = Yii::$app->user->identity;

        if (!empty($this->request->post('Users')['id'])) {
            $newUser = Users::findOne($this->request->post('Users')['id']);
            $newUser->delete();
        }
        $modelUsers = new Users();
        return $this->render('delete-user',
            [
                'currentUser' => $currentUser,
                'modelUsers'  => $modelUsers,
            ]);
    }

    public function actionAddOrg()
    {
        $currentUser = Yii::$app->user->identity;

        if (!empty($this->request->post('Users')['id'])
            && !empty($this->request->post('Event')['id'])) {

            $newEventUsers = EventUsers::find()
                ->where(['event_id' => $this->request->post('Event')['id']])
                ->andWhere(['users_id' => $this->request->post('Users')['id']])
                ->one();

            if ($newEventUsers !== null) {
                $newEventUsers->setAttribute('org', true);
                $newEventUsers->save();
            } else {
                $newEventUsers = new EventUsers();
                $newEventUsers->setAttribute('event_id', $this->request->post('Event')['id']);
                $newEventUsers->setAttribute('users_id', $this->request->post('Users')['id']);
                $newEventUsers->setAttribute('org', true);
                $newEventUsers->save();
            }
            $newUser = Users::findOne($this->request->post('Users')['id']);
            if ($newUser !== null) {
                $newUser->setAttribute('role_id',Role::ROLE_ORG);
                $newUser->save();
            }
        }

        $modelUsers = new Users();
        $modelEvent = new Event();

        $subQuery = EventUsers::find()
            ->select('event_id')
            ->andWhere(['{{event_users}}.org' => true]);
        $allEvent = Event::find()
            ->select('id,title')
            ->andWhere(['not in', '{{event}}.id', $subQuery])
            ->asArray()->all();

        $itemsEvent = \yii\helpers\ArrayHelper::map($allEvent, 'id', 'title');

        $allUsers = Users::find()
            ->select('id,email')
            ->asArray()->all();
        $itemsUsers = \yii\helpers\ArrayHelper::map($allUsers, 'id', 'email');

        $title = 'добавление организатора';

        return $this->render('add-org',
            [
                'title'       => $title,
                'currentUser' => $currentUser,
                'itemsUsers'  => $itemsUsers,
                'itemsEvent' => $itemsEvent,
                'modelUsers' => $modelUsers,
                'modelEvent' => $modelEvent,
            ]);
    }

    public function actionDeleteOrg()
    {
        $currentUser = Yii::$app->user->identity;

        if (!empty($this->request->post('DynamicModel')['ids'])) {
            $eventUsersIds = explode('_', $this->request->post('DynamicModel')['ids']);

            $eventUsers = EventUsers::find()
                ->where(['event_id' => $eventUsersIds[0]])
                ->andWhere(['users_id' => $eventUsersIds[1]])
                ->one();

            if ($eventUsers !== null) {
                $eventUsers->setAttribute('org', false);
                $eventUsers->save();
//                $eventUsers->delete();
            }
        }

        $allEvent = Event::find();
        $allEvent->select('{{event}}.id, {{event}}.title');
        $allEvent->leftJoin('{{event_users}}', '{{event}}.id = {{event_users}}.event_id');
        $allEvent->addSelect('{{event_users}}.*');
        $allEvent->andWhere(['{{event_users}}.org' => true]);
        $allEvent->leftJoin('{{users}}', '{{event_users}}.users_id = {{users}}.id');
        $allEvent->addSelect('{{users}}.email');
        $arrallEvent = $allEvent->asArray()->all();

        $arr = [];
        foreach ($arrallEvent as $item) {
            $key = $item['event_id'] . '_' . $item['users_id'];
            $arr[$key] = $item['email'] . ' мероприятие ' . $item['title'];
        }

        $title = 'удаление организатора';

        return $this->render('delete-org',
            [
                'title'       => $title,
                'currentUser' => $currentUser,
                'itemsEvent' => $arr,
            ]);
    }

    public function actionUpdateProfile()
    {
        $currentUser = Yii::$app->user->identity;

        if (!empty($this->request->post('Users')['name'])
            && !empty($this->request->post('Users')['email'])
            && !empty($this->request->post('Users')['password'])
            && !empty($this->request->post('Users')['role_id'])) {

            $newUser = Users::find()->where(['email' => $this->request->post('Users')['email']])->one();
            if ($newUser === null) {
                $newUser = new Users();
            }

            $newUser->setAttributes(
                [
                    'name' => $this->request->post('Users')['name'],
                    'email' => $this->request->post('Users')['email'],
                    'password' => $this->request->post('Users')['password'],
                    'role_id' => $this->request->post('Users')['role_id'],
                ]);

            $newUser->save();
        }
//        $modelUsers = new Users();
        $modelUsers = Users::findOne(4);
        return $this->render('update-profile',
            [
                'currentUser' => $currentUser,
                'modelUsers'  => $modelUsers,
            ]);
    }

    //1,showProfile,получить персональные данные
    //2,recovery,восстановить пароль
    //3,ban,бан юзера
    //4,invite,приглос юзера
    //5,addUser,добавить юзера изменить ему роль
    //6,deleteUser,удалить узера
    //7,addOrg,добавить организатора
    //8,deleteOrg,удалить организатора
    //9,updateProfile, изменить профиль пользователя

}
