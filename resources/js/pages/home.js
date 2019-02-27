import utilities from "../utilities/utilities";
import { TYPING_TIMOUT_INTERVAL } from "../app_config";

const channelNameInputClass = ".channel-name",
      channelsTableDivClass = ".channels-table-div",
      channelPaginateClass = ".channel-paginate",
      subscribeToChannelClass = ".subscribe-to-channel";

let typingTimer = null;

function handleChannelNameInput(isPaginationEvent, reference) {
    const $channelNameInput = $(channelNameInputClass),
          loadChannelsURL = $channelNameInput.data("loadChannelsUrl");

    let url = "";

    if(isPaginationEvent) {
        url = `${loadChannelsURL}?paginationURL=${encodeURIComponent($(reference).data("url"))}`;
    } else {
        url = `${loadChannelsURL}?searchParam=${$channelNameInput.val()}`;
    }

    function beforeSend() {
        $channelNameInput.blur();
        utilities.changeLoaderState(true);
    }

    function success(response) {
        let data = response.data;

        if(data.status) {
            $(channelsTableDivClass).empty().html(data.view);
        } else {
            window.alertify.error("Failed to load table, try again please!!");
        }

        $channelNameInput.focus();
        utilities.changeLoaderState(false);
    }

    function error() {
        $channelNameInput.focus();
        utilities.changeLoaderState(false);
        window.alertify.error("Could not load channel list, please try again.");
    }

    if(url !== "") {
        utilities.ajaxUtility.sendRequest(
            url,
            "",
            utilities.ajaxUtility.requestType.GET,
            beforeSend,
            success,
            error
        )
    }
}

function handleChannelNameKeyUp() {
    if(typingTimer) {
        clearTimeout(typingTimer);
    }

    typingTimer = setTimeout(handleChannelNameInput, TYPING_TIMOUT_INTERVAL);
}

function handleChannelNameKeyDown() {
    if(typingTimer) {
        clearTimeout(typingTimer);
    }
}

function handleSubscribeToChannel() {
    const $element = $(this),
        $parent = $element.parents().eq(1),
        $grandParent = $element.parents().eq(2),
        subscribeURL = $grandParent.data("subscribeUrl"),
        channelId = $parent.data("channelId"),
        channelName = $parent.data("channelName");

    function beforeSend() {
        utilities.changeLoaderState(true);
    }

    function success(response) {
        let data = response.data;

        if(data.status) {
            window.location.replace(data.nextURL);
        } else {
            window.alertify.error("Failed to subscribe, try again please!!");
            utilities.changeLoaderState(false);
        }
    }

    function error() {
        utilities.changeLoaderState(false);
        window.alertify.error("Failed to subscribe, try again please!!");
    }

    if(subscribeURL !== "") {
        utilities.ajaxUtility.sendRequest(
            subscribeURL,
            {
                channelID: channelId,
                channelName: channelName
            },
            utilities.ajaxUtility.requestType.POST,
            beforeSend,
            success,
            error
        )
    }
}

$(channelNameInputClass).keydown(handleChannelNameKeyDown);
$(channelNameInputClass).keyup(handleChannelNameKeyUp);
$(channelsTableDivClass).on("click", channelPaginateClass, function () {
    handleChannelNameInput(true, this);
});
$(channelsTableDivClass).on("click", subscribeToChannelClass, handleSubscribeToChannel);