const twitchEmbedDivID = "twitch-embed",
      $twitchEmbedDiv = $(`#${twitchEmbedDivID}`),
      windowWidth = $twitchEmbedDiv.width(),
      windowHeight = $twitchEmbedDiv.height(),
      channelName = $("meta[name='channel_name']").attr("content");

new Twitch.Embed(
    twitchEmbedDivID,
    {
        channel: channelName,
        width: windowWidth,
        height: windowHeight,
        allowfullscreen: true
    }
);