# Yaakov Bank - CLIENT

## Installation and configuration
```
1. Make a clone of this repository;
2. Access the root of the `cd front` project;
4. Preferably use `yarn`, install following [link](https://yarnpkg.com/getting-started/install);
5. Run `yarn` to install dependencies;
```

## Configuration

Copy the structure of the example environment variables file

```
cp .env.example .env
```

### Compile with 'hot-reload' in development
```
6. Run `yarn serve` to start
```

### Compile and minify for production
```
Rode `yarn build`
```

### List and correct files
```
Rode `yarn lint`
```

## Folder structure


└── public
└── src
    ├── assets/ # items, images and icons used in the application
    ├── components/ # shareable components throughout the application
    ├── middleware/ # responsibility for page access
    ├── router/ # route settings
    ├── services/ # configuration of services used
    ├── store # configuring and dispatching state throughout the application
    ├── styles/ # settings variables
    ├── views/ # application pages


## Environment variables:


VUE_APP_API_SERVER=http://127.0.0.1:8000/api


### Description of variables:

`VUE_APP_API_SERVER`= Inform backend url