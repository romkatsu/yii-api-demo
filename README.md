# yii api demo

| Method           | Require Auth  | Description          |
| ---------------  |:-------------:| ---------------------|
| GET  /           | no            | get application info |
| GET  /blog/      | no            | get blog records     |
| GET  /blog/[id]  | no            | get blog record      |
| POST /blog/      | yes           | create blog record   |
| PUT  /blog/[id]  | yes           | update blog record   |
| GET  /users/     | yes           |  get users           |
| GET  /users/[id] | yes           |  get user            |
| POST /auth/      | no            |  auth                |


Authorization is performed via the header X-Api-Key


http://127.0.0.1:8080 web host

http://127.0.0.1:8081 host for acceptance tests

