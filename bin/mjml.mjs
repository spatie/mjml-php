import mjml2html from 'mjml'

const args = JSON.parse(process.argv.slice(2));

const mjml = args[0];
const options = args[1];

let result = ''

try {
    result = await mjml2html(mjml, options);
} catch (exception) {
    const errorString = JSON.stringify({mjmlError: exception.toString()});

    process.stdout.write(errorString);
    process.exit(0);
}

process.stdout.write(JSON.stringify(result));
