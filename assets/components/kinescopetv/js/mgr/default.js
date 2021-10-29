function initOpenUploader() {
    initUploader();
    window.UploadingWidget.openUploader().then((open) => {
//         console.log('openUploader', open);
    });
}

/*function openUploader() {
    window.UploadingWidget.openUploader().then((open) => {
        // console.log('openUploader', open);
    });
}*/

function httpGet(url, retries, delay) {
    if (url === '' || url === null || url == 'null') return;
    retries = retries || 10;
    delay = delay || 1000;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', url, true);

    xhr.onload = function() {
      if (this.status == 200) {
        // console.log(this.response);
        let resp = JSON.parse(this.response);
        if (resp.status == 'processing') {
            setTimeout(() => {
                httpGet(url, --retries);
            }, delay);
        } else {
            document.getElementById('kinescope_tv_status').classList.remove('loading');
            document.querySelector('.kinescope-tv__message').innerHTML = 'Видео обработано!';
            document.querySelector('.kinescope-tv').value = resp.url;
        }
      } else {
          document.getElementById('kinescope_tv_status').classList.remove('loading');
          document.querySelector('.kinescope-tv__message').innerHTML = 'В ходе выполнения произошла ошибка. Проверьте консоль браузера.';
          console.log('error: ' + this.status);
      }
    };

    xhr.onerror = function() {
      console.log('error: ' + this.statusText);
    };
    
    xhr.send();
}

function initUploader() {
    if(window.UploadingWidget) {
        return;
    }

    window.UploadingWidget = KinescopeUploadingWidget.create({
        host: 'https://uploader.kinescope.io/',
        container: document.getElementById('uploader-widget'),
        token: MODx.config.kinescopetv_api_token,
        language: MODx.config.cultureKey == 'ru' ? 'ru' : 'en',
        hiddenMenuProjects: false,
    });
    
    window.UploadingWidget.on('uploader.start', function (data) {
        document.getElementById('kinescope_tv_status').classList.add('loading');
        document.querySelector('.kinescope-tv__message').innerHTML = 'Загружаем видео на сервис.';
    });
    
    window.UploadingWidget.on('uploader.error', function (data) {
        document.getElementById('kinescope_tv_status').classList.delete('loading');
        document.querySelector('.kinescope-tv__message').innerHTML = 'Произошла ошибка во время загрузки.';
    });

    window.UploadingWidget.on('uploader.done', function (data) {
        document.getElementById('kinescope_tv_status').classList.add('loading');
        document.querySelector('.kinescope-tv__message').innerHTML = 'Загрузка выполнена. Ждем, когда видео обработается.';
        if (data.video.id) {
            // console.log(data.event, data.video.id);
            
            document.querySelector('.kinescope-tv').value = data.video.id;
            
            httpGet(MODx.config.assets_url + 'components/kinescopetv/getVideoUrl.php?id=' + data.video.id, 60);
              
            if(window.UploadingWidget) {
                window.UploadingWidget.closeUploader();
                window.UploadingWidget.destroy();
                window.UploadingWidget = null;
            }
        }
    });

    return window.UploadingWidget;
}

// initUploader();