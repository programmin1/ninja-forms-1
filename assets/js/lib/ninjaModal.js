/**
 * Definition of the NinjaModal class.
 * 
 * @param data (object) The default data to be passed into the class.
 *   data.width (int) The width of the modal.
 *   data.class (string) The class to be applied to the modal.
 *   data.closeOnClick (string/bool) The click options to close the modal.
 *   data.closeOnEsc (bool) Whether or not to close the modal on escape.
 *   data.title (string) The title of the modal.
 *   data.content (string) The content of the modal.
 *   data.btnPrimary (object) Information about the primary button of the modal.
 *     btnPrimary.text (string) The text content of the button.
 *     btnPrimary.class (string) The class to be added to the button.
 *     btnPrimary.callback (function) The function to be called when the button is clicked.
 *   data.btnSecondary (object) Information about the secondary button of the modal.
 *     btnSecondary.text (string) The text content of the button.
 *     btnSecondary.class (string) The class to be added to the button.
 *     btnSecondary.callback (function) The function to be called when the button is clicked.
 *   data.useProgressBar (bool) Whether or not this modal needs the progress bar.
 */
function NinjaModal ( data ) {
    // Setup our modal settings.
    this.settings = {
        width: ( 'undefined' != typeof data.width ? data.width : 400 ),
        class: ( 'undefined' != typeof data.class ? data.class : 'dashboard-modal' ),
        closeOnClick: ( 'undefined' != typeof data.closeOnClick ? data.closeOnClick : 'body' ),
        closeOnEsc: ( 'undefined' != typeof data.closeOnEsc ? data.closeOnEsc : true )
    }
    // Setup our title.
    this.title = ( 'undefined' != typeof data.title ? data.title : '' );
    // Setup our content.
    this.content = ( 'undefined' != typeof data.content ? data.content : '' );
    // See if we need buttons.
    this.buttons = {};
    this.buttons.primary = {};
    this.buttons.secondary = {};
    this.buttons.primary.data = ( 'undefined' != typeof data.btnPrimary ? data.btnPrimary : false );
    this.buttons.secondary.data = ( 'undefined' != typeof data.btnSecondary ? data.btnSecondary : false );
    // See if we need the progress bar.
    this.useProgressBar = ( 'undefined' !=  typeof data.useProgressBar ? data.useProgressBar : false );
    // Declare our popup item.
    this.popup;
    // Declare our button booleans.
    this.hasPrimary = false;
    this.hasSecondary = false;
    // Initialize the popup.
    this.initModal();
    // Show the popup.
    this.toggleModal( true );
}


/**
 * Function to initialize the popup modal.
 */
NinjaModal.prototype.initModal = function () {
    // Setup our popup.
    this.popup = new jBox( 'Modal', {
        width: this.settings.width,
        addClass: this.settings.class,
        overlay: true,
        closeOnClick: this.settings.closeOnClick,
        closeOnEsc: this.settings.closeOnEsc
    } );
    // Render the title.
    this.renderTitle();
    // Initialize the buttons (if they exist).
    this.initButtons();
    // Render the content.
    this.renderContent();
}


/**
 * Function to initialize the buttons.
 */
NinjaModal.prototype.initButtons = function () {
    // If we have data for a primary button...
    if ( this.buttons.primary.data ) {
        // Create the button.
        var primary = document.createElement( 'div' );
        primary.id = 'button-primary';
        primary.classList.add( 'nf-button', 'primary', 'pull-right' );
        // If we have a class...
        if ( this.buttons.primary.data.class ) {
            // Add it to the class list.
            primary.classList.add( this.buttons.primary.data.class );
        }
        // If we were given button text...
        if ( 'undefined' != typeof this.buttons.primary.data.text ) {
            // Use it.
            primary.innerHTML = this.buttons.primary.data.text;
        } // Otherwise... (We were not given text.)
        else {
            // Use default text.
            // TODO: translate
            primary.innerHTML = 'Confirm';
        }
        this.buttons.primary.dom = primary;
        // Attach the callback.
        this.buttons.primary.callback = this.buttons.primary.data.callback;
        // Record that we have a primary button.
        this.hasPrimary = true;
        // Garbage collection...
        delete this.buttons.primary.data;
    }
    // If we have data for a secondary button...
    if ( this.buttons.secondary.data ) {
        // Create the button.
        var secondary = document.createElement( 'div' );
        secondary.id = 'button-secondary';
        secondary.classList.add( 'nf-button', 'secondary' );
        // If we have a class...
        if ( this.buttons.secondary.data.class ) {
            // Add it to the class list.
            secondary.classList.add( this.buttons.secondary.data.class );
        }
        // If we were given button text...
        if ( 'undefined' != typeof this.buttons.secondary.data.text ) {
            // Use it.
            secondary.innerHTML = this.buttons.secondary.data.text;
        } // Otherwise... (We were not given text.)
        else {
            // Use default text.
            // TODO: translate
            secondary.innerHTML = 'Cancel';
        }
        this.buttons.secondary.dom = secondary;
        // Attach the callback.
        this.buttons.secondary.callback = this.buttons.secondary.data.callback;
        // Record that we have a secondary button.
        this.hasSecondary = true;
        // Garbage collection...
        delete this.buttons.secondary.data;
    }
}


/**
 * Function to toggle the visibility of the popup.
 * 
 * @param show (bool) Whether or not to show the popup.
 */
NinjaModal.prototype.toggleModal = function ( show ) {
    // If we were told to show the modal...
    if ( show ) {
        // Open it.
        this.popup.open();
    } // Otherwise... (We were told to hide it.)
    else {
        // Close it.
        this.popup.close();
    }
}


/**
 * Function to append the title to the popup.
 */
NinjaModal.prototype.renderTitle = function () {
    // If we have a title...
    if ( '' != this.title ) {
        // Set our title.
        this.popup.setTitle( this.title );
    }
}


/**
 * Function to append the content to the popup.
 */
NinjaModal.prototype.renderContent = function () {
    // Delcare our template.
    var contentBox = document.createElement( 'div' );
    contentBox.classList.add( 'message' );
    contentBox.style.padding = '0px 20px 20px 20px';
    // Import our content.
    contentBox.innerHTML = this.content;

    // If we were told to use the progress bar...
    if ( this.useProgressBar ) {
        // Define our progress block.
        var progressBlock = document.createElement( 'div' );
        progressBlock.id = 'nf-progress-block';
        progressBlock.style.display = 'none';
        // Define our progress bar.
        var progressBar = document.createElement( 'div' );
        progressBar.classList.add( 'nf-progress-bar' );
        var progressSlider = document.createElement( 'div' );
        progressSlider.classList.add( 'nf-progress-bar-slider' );
        progressBar.appendChild( progressSlider );
        progressBlock.appendChild( progressBar );
        // Define our loading text.
        // TODO: maybe make this configurable?
        var lodingText = document.createElement( 'p' );
        lodingText.id = 'nf-loading-text';
        lodingText.style.color = '#1ea9ea';
        lodingText.style.fontWeight = 'bold';
        // TODO: translate
        lodingText.innerHTML = 'Loading...';
        progressBlock.appendChild( loadingText );
        // Append it to the content box.
        contentBox.appendChild( progressBlock );
    }
    // If we have buttons...
    if ( this.hasPrimary || this.hasSecondary ) {
        // Define our action block.
        var actionBlock = document.createElement( 'div' );
        actionBlock.id = 'nf-action-buttons';
        actionBlock.classList.add( 'buttons' );
        // Insert the primary button, if one exists.
        if ( this.hasPrimary ) actionBlock.appendChild( this.buttons.primary.dom );
        // Insert the secondary button, if one exists.
        if ( this.hasSecondary ) actionBlock.appendChild( this.buttons.secondary.dom );
        // Append it to the content box.
        contentBox.appendChild( actionBlock );
        this.popup.onOpen = function() {
            this.buttons.primary.dom.onclick = this.buttons.primary.callback;
            this.buttons.secondary.dom.onclick = this.buttons.secondary.callback;
        }
    }
    // Set our content.
    this.popup.setContent( document.createElement( 'div' ).appendChild( contentBox ).innerHTML );
}


/**
 * Function to update the title of the popup.
 * 
 * @param title (string) The new title.
 */
NinjaModal.prototype.updateTitle = function ( title ) {
    // Set the new title.
    this.title = title;
    // Re-render.
    this.renderTitle();
}

/**
 * Function to update the content of the popup.
 * 
 * @param content (string) The new content.
 */
NinjaModal.prototype.updateContent = function ( content ) {
    // Set the new content.
    this.content = content;
    // Re-render.
    this.renderContent();
}