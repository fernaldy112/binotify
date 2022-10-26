function album_ClickHandler(id) {
    let loc = "/album_detail?s=";
    let loc_real = loc.concat(id);
    location.href = loc_real;
}