# onelibrary
A library for small company and organization. Include function:
- Book management
- Borrow, notify and fine management
- Book purchasing and plan management
- Librarian and volunteer management
- Librarian on-duty arrangement
- Email and calendar system

Write by PHP Yii 1.1 and bootstrap. Used since 2014 in Nokia.

Contact hebihong@163.com when you need more help.

NOTE: Usually this repo will not add new features anymore, please follow new version Onelibrary-Pro: https://github.com/onecmd/onelibrary-pro

## Usage

### Build
It run as a docker container, build a docker image at first.
Run command to build the docker image:
```
cd ./docker
sh ./build.sh

docker images
```

### Run and start
Run as a docker container by command:
```
cd ./docker
sh ./run.sh start
```

### Stop
Run command:
```
cd ./docker
sh ./run.sh stop
```

### Restart
Run command:
```
cd ./docker
sh ./run.sh restart
```

## Dashboard

### Dashboard
![Dashboard](./doc/images/dashboard.PNG)

### Login
![Login](./doc/images/login.PNG)

## Book management

### Book search and view for user
- Book search and view for user
![Book search and view for user](./doc/images/search_book_user.PNG)

- Book borrow history
![Book borrow history](./doc/images/book_read_history.PNG)

- Fine list
![Fine list](./doc/images/fine_list.PNG)

### Book search, list, edit for librarian
![Book search, list, edit for librarian](./doc/images/book_admin.PNG)

### Add new book for librarian
![Add new book](./doc/images/add_book.PNG)

## Book purchasing

### Submit book request
![Submit book request](./doc/images/book_request.PNG)

### Purchasing plan management
- Purchasing plan request
![Purchasing plan request](./doc/images/buy_plan_request.PNG)

- Purchasing plan
![Purchasing plan](./doc/images/buy_plan.PNG)

- Purchasing plan admin
![Purchasing plan admin](./doc/images/buy_plan_admin.PNG)
![Purchasing plan list](./doc/images/buy_plan_list.PNG)


## Librarian and volunteer management

### Add, edit, delete librarian and volunteer, and role management
![Add, edit, delete librarian and volunteer](./doc/images/user_admin.PNG)

## Librarian on-duty arrangement

###  Duty arrangement
![Duty arrangement](./doc/images/duty_plan.PNG)

### Duty calendar
It can send calendar email to on-duty librarian.
![Duty calendar](./doc/images/duty_calendar.PNG)
