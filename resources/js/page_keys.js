/***
 * These keys are used to avoid conflict in same code base being available via multiple pages
 * this issue arises when entire JS is combined in 1
 *
 * This object mirrors keys on Objects\Enums\PageKeys.php
 *
 * WARNING: THIS OBJECT SHOULD REMAIN UP TO DATE WITH THE PHP SIBLING, ELSE APPLICATION WILL FAIL
 */

window.pageKeys = {
    HOME: 'home',
    CHANNEL_STREAM: 'channel_stream',
    _currentKey: '',

    setCurrentKey: function (key) {
        this._currentKey = key;
    },

    getCurrentKey: function () {
        return this._currentKey;
    }
};
