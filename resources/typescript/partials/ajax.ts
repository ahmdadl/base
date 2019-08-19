interface Header {
    key: string,
    value: string
}

/**
 * Handle Ajax Requests
 */
class Ajax
{
    /**
     * default header for get method
     * 
     * @static
     * @type {Header}
     * @memberof Ajax
     * 
     * @default
     */
    static TEXT_HEADER: Header = {
        key: 'Content-Type',
        value: 'text/plain;charset=UTF-8'
    };
    /**
     * default header for post method
     *
     * @static
     * @type {Header}
     * @memberof Ajax
     */
    static POST_HEADER: Header = {
        key: 'Content-Type',
        value: 'application/x-www-form-urlencoded;charset=UTF-8'
    };
    /**
     * default header for json data type
     *
     * @static
     * @type {Header}
     * @memberof Ajax
     */
    static JSON_HEADER: Header = {
        key: 'Content-Type',
        value: 'application/json;charset=UTF-8'
    }

    /**
     * handle all ajax requests
     *
     * @private
     * @type {XMLHttpRequest}
     * @memberof Ajax
     */
    private xhttp: XMLHttpRequest;

    /**
     * page url to connect to
     *
     * @private
     * @type {string}
     * @memberof Ajax
     */
    private _url: string;
    /**
     * lowercase http
     *
     * @private
     * @type {string}
     * @memberof Ajax
     */
    private _method: string;
    /**
     * add all data into array and resolve it as urlencoded
     *
     * @private
     * @type {Array<Header>}
     * @memberof Ajax
     */
    private postData: object;
    /**
     * add all headers into array and set it
     *
     * @private
     * @type {Array<Header>}
     * @memberof Ajax
     */
    private _headers: Array<Header> = [];


    constructor(
        url: string,
        method: string = 'get',
        data: object = {},
        headers: Array<Header> | undefined = []
    ) {
        this._url = url;
        this._method = method.toUpperCase();
        this.postData = data;
        this._headers = headers;

        this.xhttp = new XMLHttpRequest;
    }

    /**
     * add new header for that instance
     *
     * @param {string} key
     * @param {string} value
     * @memberof Ajax
     */
    public addHeader(key: string, value: string) : void
    {
        this._headers.push({
            key,
            value
        });
    }

    /**
     * add data for post request
     *
     * @param {string} key
     * @param {*} value
     * @memberof Ajax
     */
    public addData(key: string, value: any) : void
    {
        this.postData = {
            key: value,
            val: 'asd'
        };
    }

    /**
     * send the request and retriving the data from server as string
     *
     * @returns {Promise<string>}
     * @memberof Ajax
     */
    public async send() : Promise<any>
    {
        // generate data as url query
        let dataUrl: string = await this.getData();
        
        // open the request before setting the headers
        this.xhttp.open(this._method, this._url, true);

        // attach all headers to this request
        await this.setHeaders();

        return new Promise<any>((res, rej) => {
            this.xhttp.onreadystatechange = function () {
                // if connection has done
                if (this.readyState === XMLHttpRequest.DONE) {
                    // check if statusCode is 200 resolve success
                    if (this.status === 200) res(this.response);
                    else rej(this.status); // show error
                }
            };

            // if the timeout has passed show error with timeout
            this.xhttp.ontimeout = function () {
                rej('timeout');
            };

            // send the request with data
            this.xhttp.send(dataUrl);
        });
    }

    /**
     * set the http headers
     *
     * @private
     * @returns {Promise<boolean>}
     * @memberof Ajax
     */
    private async setHeaders() : Promise<boolean>
    {
        
        for (const h of this._headers) {
            this.xhttp.setRequestHeader(h.key, h.value);
        }
        return true;
    }

    /**
     * turn data object{key: value} into url query params
     *
     * @private
     * @returns {Promise<string>}
     * @memberof Ajax
     */
    private async getData() : Promise<string>
    {
        let encoded = '';

        for (let prop in this.postData) {
            if (this.postData.hasOwnProperty(prop)) {
                if (encoded.length > 0) {
                    encoded += '&';
                }
                encoded += encodeURI(prop + '=' + this.postData[prop])
            }
        }
        return encoded;
    }
}
