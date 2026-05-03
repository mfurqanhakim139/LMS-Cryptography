/** crypto_client.js - AES-256-GCM Frontend */
const SECRET_KEY_STRING = 'EduPortal_Q1_Research_Key_32Byte'; 

async function getCryptoKey() {
    const encoder = new TextEncoder();
    const keyMaterial = encoder.encode(SECRET_KEY_STRING); // Pastikan tepat 32 karakter
    
    return await window.crypto.subtle.importKey(
        'raw', 
        keyMaterial, 
        { name: 'AES-GCM' }, 
        false, 
        ['encrypt', 'decrypt']
    );
}
async function decryptPayload(encryptedPayload, ivBase64, tagBase64) {
    const t0 = performance.now();
    const key = await getCryptoKey();
    
    const iv = Uint8Array.from(atob(ivBase64), c => c.charCodeAt(0));
    const ciphertext = Uint8Array.from(atob(encryptedPayload), c => c.charCodeAt(0));
    const tag = Uint8Array.from(atob(tagBase64), c => c.charCodeAt(0));

    const combined = new Uint8Array(ciphertext.length + tag.length);
    combined.set(ciphertext);
    combined.set(tag, ciphertext.length);

    try {
        const decryptedBuffer = await window.crypto.subtle.decrypt({ name: 'AES-GCM', iv: iv }, key, combined);
        const decoder = new TextDecoder();
        const t1 = performance.now();
        
        return {
            data: JSON.parse(decoder.decode(decryptedBuffer)),
            benchmark_ms: t1 - t0
        };
    } catch (e) {
        console.error("Autentikasi Gagal: Kunci salah atau data termanipulasi.", e);
        return null;
    }
}
