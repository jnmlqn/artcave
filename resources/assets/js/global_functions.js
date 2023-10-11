var _token = $('meta[name="csrf-token"]').attr('content');

$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

function findObjectBySubKey(array, key1, key2, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key1][key2] == value) {
            return i;
        }
    }
    return null;
} 

function multiArraySort(array, key) {
    array.sort(function (a,b) {
        const dateA = a[key];
        const dateB = b[key];

        let sorted = 0;
        if (dateA > dateB) {
            sorted = -1;
        } else if (dateA < dateB) {
            sorted = 1;
        }
        return sorted;
    });
}

function ajaxCall(url, data, type) {
    return $.ajax({
        url: url,
        data: data,
        type: type
    });
}

function ajaxCall2(url, data, type) {
    return $.ajax({
        url: url,
        data: data,
        type: type,
        cache: false,
        contentType: false,
        processData: false,
    });
}

function getTime() {
    date = new Date();
    var hours = date.getHours();
    var minutes = date.getMinutes();
    hours = hours < 10 ? '0'+hours : hours;
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes;
    return strTime;
}

function getDate() {
    let date = new Date();
    return `${date.getFullYear()}-${(date.getMonth() < 10 ? "0" + date.getMonth() : date.getMonth())}-${(date.getDate() < 10 ? "0" + date.getDate() : date.getDate())}`;
}
