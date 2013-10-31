process timeline visualizer
=======================================

![image](https://raw.github.com/miukoba/process-timeline-visualizer/master/example-image.png)

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
