import mjml2html from 'mjml'

export const handle = async function (event) {
    let result = ''

    try {
        result = mjml2html(event.mjml, event.options);
    } catch (exception) {
        return JSON.stringify({mjmlError: exception.toString()});
    }

    return JSON.stringify(result);
}
