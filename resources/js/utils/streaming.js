import axios from 'axios';

export async function streaming() {
    
    async function fetching() {
        try {
            const response = await axios.get('/api/streaming');
            return response.data;
        } catch (error) {
            console.error('Error fetching streaming data on akiba api:', error);
            throw error;
        }
    }

    // primeira chamada: retorna os dados
    const streamingReturn = await fetching();

    // inicia loop de atualização
    setInterval(() => {
        fetching().catch(() => {});
    }, 60 * 1000); // Atualiza a cada 60 segundos

    return streamingReturn; 
}
