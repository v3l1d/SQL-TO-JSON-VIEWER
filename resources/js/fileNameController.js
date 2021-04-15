const directory = "./storage/app/uploads/";
const fs=require('fs');
const path = require("path");

//sort by date
const orderReccentFiles = directory => {
    return fs
        .readdirSync(directory)
        .filter(file => fs.lstatSync(path.join(directory, file)).isFile())
        .map(file => ({
            file,
            mtime: fs.lstatSync(path.join(directory, file)).mtime
        }))
        .sort((a, b) => b.mtime.getTime() - a.mtime.getTime());
};

//get latest recent file
const getMostRecentFile = () => {
    const files = orderReccentFiles(directory);
    return files.length ? files[0] : undefined;
};

//get latest file name
const getLatestFileName = () => {
    let path = directory; //uploads path
    let latestFileName = getMostRecentFile().file; //getMostRecentFile returns the object -> latestFileName gets the only name
    return latestFileName;
};

module.exports = {
    getLatestFileName
}