// node_scripts/jweEncryption.js
const jose = require('node-jose');

async function jweEncryption(publicKey, payload) {
    try {
        const input = JSON.stringify(payload);
        const pemkey = `-----BEGIN PUBLIC KEY-----${publicKey}-----END PUBLIC KEY-----`;
        const key = await jose.JWK.asKey(pemkey, 'pem');
        const jwe = await jose.JWE.createEncrypt({ format: 'compact', alg: 'RSA-OAEP-256', enc: 'A256CBC-HS512' }, key)
            .update(input)
            .final();
        return jwe;
    } catch (error) {
        console.error('Encryption error:', error);
        throw error;
    }
}

// Read input from the command line
const publicKey = process.argv[2];
const payload = JSON.parse(process.argv[3]);

jweEncryption(publicKey, payload).then(jwe => {
    console.log(JSON.stringify(jwe));
}).catch(error => {
    console.error('Encryption failed:', error);
    process.exit(1); 
});