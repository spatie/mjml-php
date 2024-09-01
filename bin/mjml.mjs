import mjml2html from 'mjml'

const args = JSON.parse(atob(process.argv.slice(2)));

const mjml = args[0];
const options = args[1];

let result = ''

try {
    result = await mjml2html(mjml, options);
} catch (exception) {
    const errorString = JSON.stringify({mjmlError: exception.toString()});

    process.stdout.write(utoa(errorString));
    process.exit(0);
}

process.stdout.write(utoa(JSON.stringify(result)));

/**
 * Unicode to ASCII (encode data to Base64)
 * @param {string} data
 * @return {string}
 */
function utoa(data) {
    return btoa(unescape(encodeURIComponent(data)));
}
