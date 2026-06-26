const getLevenshteinDistance = (a, b) => {
    if(a.length === 0) return b.length;
    if(b.length === 0) return a.length;

    const matrix = [];

    for(let i = 0; i <= b.length; i++){
        matrix[i] = [i];
    }
    for(let j = 0; j <= a.length; j++){
        matrix[0][j] = j;
    }

    for(let i = 1; i <= b.length; i++){
        for(let j = 1; j <= a.length; j++){
            if(b.charAt(i-1) === a.charAt(j-1)){
                matrix[i][j] = matrix[i-1][j-1];
            } else {
                matrix[i][j] = Math.min(matrix[i-1][j-1] + 1, Math.min(matrix[i][j-1] + 1, matrix[i-1][j] + 1));
            }
        }
    }
    return matrix[b.length][a.length];
};

const isFuzzyMatch = (text, query) => {
    if (!query) return true;
    
    // Normalization
    const normText = text.replace(/[^a-z0-9]/gi, ' ').replace(/\s+/g, ' ').trim();
    const normQuery = query.replace(/[^a-z0-9]/gi, ' ').replace(/\s+/g, ' ').trim();
    
    if (normText.includes(normQuery)) return true;

    const queryWords = normQuery.split(' ');
    const textWords = normText.split(' ');

    let allWordsMatched = true;
    for (let qWord of queryWords) {
        if (qWord.length === 0) continue;
        
        let wordMatched = false;
        for (let tWord of textWords) {
            if (tWord.includes(qWord)) {
                wordMatched = true;
                break;
            }
            
            const maxTypo = qWord.length <= 4 ? 1 : 2;
            if (Math.abs(tWord.length - qWord.length) <= maxTypo) {
                if (getLevenshteinDistance(tWord, qWord) <= maxTypo) {
                    wordMatched = true;
                    break;
                }
            }
        }
        
        if (!wordMatched) {
            allWordsMatched = false;
            break;
        }
    }

    return allWordsMatched;
};

console.log("dasar dasar in dasar-dasar :", isFuzzyMatch("dasar-dasar", "dasar dasar"));
console.log("dasr in dasar-dasar :", isFuzzyMatch("dasar-dasar", "dasr"));
console.log("prinsip prinsip biokimia in Prinsip-Prinsip Biokimia :", isFuzzyMatch("prinsip-prinsip biokimia", "prinsip prinsip biokimia"));
console.log("priinsip in Prinsip-Prinsip Biokimia :", isFuzzyMatch("prinsip-prinsip biokimia", "priinsip"));
console.log("asdf in dasar-dasar :", isFuzzyMatch("dasar-dasar", "asdf"));
