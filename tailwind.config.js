module.exports = {
    purge : {
        enabled : true,
        content : [
            './resources/**/*.blade.php',
            './resources/**/*.vue',
        ],
    },
    darkMode : false, // or 'media' or 'class'
    theme : {
        boxShadow : {
            'sm' : '0 0 2px 0 rgba(0, 0, 0, 0.05)',
            'DEFAULT' : '0 0 5px 0 rgba(0, 0, 0, 0.08)',
            'md' : '0 0 6px -1px rgba(0, 0, 0, 0.1), 0 0 4px -1px rgba(0, 0, 0, 0.06)',
            'lg' : '0 0 15px -3px rgba(0, 0, 0, 0.1), 0 0 6px -2px rgba(0, 0, 0, 0.05)',
            'xl' : '0 0 25px -5px rgba(0, 0, 0, 0.1), 0 0 10px -5px rgba(0, 0, 0, 0.04)',
            '2xl' : '0 0 50px -12px rgba(0, 0, 0, 0.25)',
            '3xl' : '0 0 60px -15px rgba(0, 0, 0, 0.3)',
            'inner' : 'inset 0 0 4px 0 rgba(0, 0, 0, 0.06)',
            'none' : 'none',
        },
        extend : {
            backgroundColor : {
                'page' : 'var(--page-background-color)',
                'card' : 'var(--card-background-color)',
                'button' : 'var(--button-background-color)',
                'header' : 'var(--header-background-color)',
                'input' : 'var(--input-background-color)',
            },
            colors : {
                'default' : 'var(--default-color)',
                'muted' : 'var(--muted-color)',
                'muted-light' : 'var(--muted-light-color)',
                'accent' : 'var(--accent-color)',
            },
        },
    },
    variants : {
        extend : {},
    },
    plugins : [],
}
