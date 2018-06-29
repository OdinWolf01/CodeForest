
$(document).ready(function(){
  var myMenu = [{

    // Menu Icon.
    // This example uses Font Awesome Iconic Font.
    icon: 'fa fa-home',

    // Menu Label
    label: 'Homepage',

    // Callback
    action: function(option, contextMenuIndex, optionIndex) {},

    // An array of submenu objects
    submenu: null,

    // is disabled?
    disabled: false   //Disabled status of the option
  },
  {
    icon: 'fa fa-user',
    label: 'Profile',
    action: function(option, contextMenuIndex, optionIndex) {},
    submenu: null,
    disabled: false
  },
  {
    icon: 'fa fa-envelope',
    label: 'Contact',
    action: function(option, contextMenuIndex, optionIndex) {},
    submenu: null,
    disabled: false
  },
  {
    //Menu separator
    separator: true
  },
  {
    icon: 'fa fa-share',
    label: 'Social Share',
    action: function(option, contextMenuIndex, optionIndex) {},
    submenu: [{ // sub menus
      icon: 'fa fa-facebook',
      label: 'Facebook',
      action: function(option, contextMenuIndex, optionIndex) {},
      submenu: null,
      disabled: false
    },
    {
      icon: 'fa fa-twitter',
      label: 'Twitter',
      action: function(option, contextMenuIndex, optionIndex) {},
      submenu: null,
      disabled: false
    },
    {
      icon: 'fa fa-google-plus',
      label: 'Google Plus',
      action: function(option, contextMenuIndex, optionIndex) {},
      submenu: null,
      disabled: false
    }],
    disabled: false
  },
];
$('.demo').on('contextmenu', function(e) {
  e.preventDefault();
  superCm.createMenu(myMenu, e);
});

});
