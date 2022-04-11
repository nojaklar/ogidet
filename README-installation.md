ogidet installation
===================

Download and install Docker
---------------------------

To simplify the installation process, we recommend to use docker. You can find how to install it for your operating system by following these links.

Windows:

```
$ https://docs.docker.com/desktop/windows/install/
```

Linux:

```
$ https://docs.docker.com/engine/install/ubuntu/
```

Mac:

```
$ https://docs.docker.com/desktop/mac/install/
```


Run the application
---------------------------

To start the application, use the following command. The option "-d" makes it run in background.

```
docker-compose up -d
```

To stop the application, use the following command.

```
docker-compose down
```
The option "-v db" can be used to reset the database. 
```
docker-compose down -v db
```