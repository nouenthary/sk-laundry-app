import {
    useState
} from 'react';

function useToken() {
    const getToken = () => {
        let tokenString = null;

        try {
            tokenString = localStorage.getItem('token');
        } catch (e) {
            console.log(e);
            return;
        }
        return tokenString
    };

    const [token, setToken] = useState(getToken());

    const saveToken = (userToken) => {
        localStorage.setItem('token', userToken);
        setToken(userToken.token);
    };

    return {
        setToken: saveToken,
        token
    }
}

export default useToken;
