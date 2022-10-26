function album_ClickHandler(id) {
    let loc = "/album_detail?s=";
    let loc_real = loc.concat(id);
    location.href = loc_real;
}

function album_detail_ClickHandler(id) {
    let loc = "/listen?s=";
    let loc_real = loc.concat(id);
    location.href = loc_real;
}