export default class BirdboardForm {
    constructor ( data ) {
        this.originalData = data;
        this.setDefault();
    }

    setDefault = () => {
        this.submitted = false;
        this.data = JSON.parse( JSON.stringify( this.originalData ) );
        this.errors = {};
    };

    post = ( endpoint ) => this.#submit( endpoint, 'post' );

    patch = ( endpoint ) => this.#submit( endpoint, 'patch' );

    delete = ( endpoint ) => this.#submit( endpoint, 'delete' );

    #submit = ( endpoint, method ) => {
        if ( this.submitted ) throw 'Form has been already submitted';
        this.submitted = true;
        return this.#sendData( endpoint, method );
    };

    #sendData = ( endpoint, method ) => {
        return axios[ method ]( endpoint, this.data )
            .then( this.#onSuccess )
            .catch( this.#onFail );
    }

    #onSuccess = ( response ) => {
        return response;
    };

    #onFail = ( errors ) => {
        this.submitted = false;
        this.errors = errors.response.data.errors;
        throw errors;
    };
}
