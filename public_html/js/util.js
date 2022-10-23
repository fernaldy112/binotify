function toDurationString(duration) {
    const hour = Math.floor(duration / 3600);
    const minutePortion = duration % 3600;
    let min = Math.floor(minutePortion / 60) + "";
    let sec = minutePortion % 60 + "";

    let dur = "";

    if (hour > 0) {
        dur = `${hour}:`;
        min = min.padStart(2, '0');
    }

    sec = sec.padStart(2, '0');
    return `${dur}${min}:${sec}`;
}