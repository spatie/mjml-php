import mjml2html from 'mjml'

const args = JSON.parse(process.argv.slice(2));

const mjml = args[0];
const options = args[1];

const result = mjml2html(mjml);

process.stdout.write(JSON.stringify(result));
