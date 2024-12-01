import React, { useState } from 'react';

const SearchForm = () => {
    const [search, setSearch] = useState('');

    const handleSubmit = (event) => {
        event.preventDefault();
        window.location.href = `/?search=${search}`;
    };

    return (
        <div id="search-container" className="col-md-12">
            <h1>Busque um Comunicado</h1>
            <form onSubmit={handleSubmit}>
                <div className="input-group">
                    <input
                        type="text"
                        id="search"
                        name="search"
                        className="form-control"
                        placeholder="Buscar..."
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                    />
                    <div className="input-group-append">
                        <input className="btn btn-primary" type="submit" value="Buscar" />
                    </div>
                </div>
            </form>
        </div>
    );
};

export default SearchForm;
