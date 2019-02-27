import utilities from './utilities/utilities';

window.utilities = utilities;

$(document).ready(function () {
   switch (window.pageKeys.getCurrentKey()) {
       case window.pageKeys.HOME:
           require('./pages/home');
           break;
       case window.pageKeys.CHANNEL_STREAM:
           require('./pages/channel_stream');
           require('./pages/recent_events');
           break;
   }
});