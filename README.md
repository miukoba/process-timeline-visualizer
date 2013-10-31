process timeline visualizer
=======================================

## setting

### edit process-logger.sh

- YOUR-GREP-KEYWORD
- /path/to/

### crontab -e

```
* * * * * /path/to/process-logger.sh
```


## develop

```
php -S localhost:8080
```

open http://localhost:8080/
