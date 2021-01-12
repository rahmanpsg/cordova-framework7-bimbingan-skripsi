var app = new Framework7({
  // App root element
  root: '#app',
  // App Name
  name: 'Bimbingan Skripsi',
  // App id
  id: 'com.bimbingan.skripsi',
  // theme: 'ios',
  on: {
    routerAjaxStart: () => {
      app.preloader.show();
    },
    routerAjaxSuccess: () => {
      app.preloader.hide();
    },
    routerAjaxError: () => {
      app.preloader.hide();
      app.dialog.preloader('Tidak dapat terhubung ke server...');
    }
  },
  // Enable swipe panel
  panel: {
    swipe: 'left',
  },
  view: {
    stackPages: true
  },
  // Add default routes
  routes: [{
    path: '/login/',
    componentUrl: './pages/login.html',
  }, {
    path: '/mahasiswa/',
    componentUrl: './pages/mahasiswa.html'
  }, {
    path: '/dosen/',
    componentUrl: './pages/dosen.html'
  }, {
    path: '/bimbingan/:nim/:nama/:pembimbing/:judul/:total',
    componentUrl: './pages/bimbingan.html'
  }],
});

var mainView = app.views.create('.view-main');

var $$ = Dom7;

// const URL = 'http://192.168.43.78/bimbingan-skripsi-server/api/';
const URL = 'https://bimbingan-skripsi-online.000webhostapp.com/api/';

formProses = new formProses(URL);

if (navigator.connection.type == 'none') {
  app.dialog.alert('Anda tidak memiliki koneksi internet', 'Informasi');
}

function cekLogin() {
  const hasLogin = localStorage.getItem('hasLogin');
  if (hasLogin == 'mahasiswa') {
    mainView.router.navigate('/mahasiswa/', {
      reloadAll: true
    });
  } else
  if (hasLogin == 'dosen') {
    mainView.router.navigate('/dosen/', {
      reloadAll: true
    });
  } else {
    mainView.router.navigate('/login/', {
      reloadAll: true
    });
  }
}

function generateID(tbl, kode) {
  const id = formProses.createID({
    tabel: tbl,
    kode: kode,
    panjang: 5
  });

  return id;
}

Template7.registerHelper('dateHelper', function (date) {
  const str = date.split(' ');
  return `${str[0]} <small>${str[1]}</small>`;
});

Template7.registerHelper('cekTotal', function (total) {
  if (total > 0) {
    return '<i class="icon f7-icons" style="color:#0c01ba;">person_crop_circle_badge_exclam</i>'
  } else {
    return '<i class="icon f7-icons" style="color:#0c01ba;">person_circle</i>'
  }
});

function serializeArray(form) {
  var arr = [];
  Array.prototype.slice.call(form.elements).forEach(function (field) {
    if (!field.name || field.disabled || ['file', 'reset', 'submit', 'button'].indexOf(field.type) > -1) return;
    if (field.type === 'select-multiple') {
      Array.prototype.slice.call(field.options).forEach(function (option) {
        if (!option.selected) return;
        arr.push({
          name: field.name,
          value: option.value
        });
      });
      return;
    }
    if (['checkbox', 'radio'].indexOf(field.type) > -1 && !field.checked) return;
    arr.push({
      name: field.name,
      value: field.value
    });
  });
  return arr;
};

document.addEventListener("deviceready", onDeviceReady, false);

function onDeviceReady() {
  cekLogin();
  // NotificationHadle();
  document.addEventListener("backbutton", onBackKeyDown, false);

  app.statusbar.overlaysWebView(true)
  app.statusbar.setTextColor('white')
  // app.statusbar.setBackgroundColor('#0c01ba');

}

// function NotificationHadle() {

//   FirebasePlugin.onMessageReceived(function (message) {

//     // alert("Message type: " + message.messageType);

//     if (message.messageType = == "notification") {
//       // alert("Notification message received");
//       var notificationFull = app.notification.create({
//         icon: '<i class="icon demo-icon">7</i>',
//         title: 'Bimbingan Skripsi Online',
//         titleRightText: 'sekarang',
//         subtitle: message.title,
//         text: message.body,
//         closeTimeout: 3000,
//       });

//       if (message.tap) {
//         alert("Tapped in " + message.tap);
//       }
//     }
//     // alert(message);
//   }, function (error) {
//     // alert(error);
//   });
// }

function saveToken(oldToken) {
  window.FirebasePlugin.getToken(function (token) {
    const level = localStorage.getItem('hasLogin');
    const data = [{
      name: 'token',
      value: token
    }]

    var where;

    if (level == 'mahasiswa') {
      where = {
        nim: localStorage.getItem('username')
      }
    } else
    if (level == 'dosen') {
      where = {
        nbm: localStorage.getItem('username')
      }
    }

    if (oldToken !== token) {
      formProses.update(level, data, where)
    }

  })
}

var opened = 0;

function exitApp() {
  if (opened > 0) {
    return false;
  } else {
    app.dialog.confirm('Anda yakin untuk menutup aplikasi?', 'Informasi',
      function () {
        navigator.app.exitApp();
      },
      function () {
        opened = 0;
        return false;
      }
    );
    opened = 1;
  }
}

function onBackKeyDown() {
  // Handle the back button
  if ($$('.modal-in').length > 0) {
    app.sheet.close('.modal-in')
  } else if (app.views.main.history.length == 1) {
    exitApp();
    e.preventDefault();
  } else {
    app.dialog.close();
    app.views.main.router.back();
    return false;
  }
}