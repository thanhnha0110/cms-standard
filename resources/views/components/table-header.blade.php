<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="dataTables_length" id="m_table_1_length">
            <label>Show 
                <select name="size" class="custom-select custom-select-sm form-control form-control-sm" onchange="updateDataLength(this.value)">
                    <option value="10" {{ request('size') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('size') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('size') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('size') == 100 ? 'selected' : '' }}>100</option>
                </select> entries
            </label>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div id="m_table_1_filter" class="dataTables_filter">
            <label>Search:
                <input type="search" class="form-control form-control-sm" placeholder="" name="search" value="{{ request('search') }}" onkeyup="debouncedUpdateSearch(this.value)">
            </label>
        </div>
    </div>
</div>


<script>
    let searchTimeout;

    function updateDataLength(length) {
        const url = new URL(window.location.href);
        url.searchParams.set('size', length);
        window.location.href = url;
    }

    function updateSearch(query) {
        const url = new URL(window.location.href);
        url.searchParams.set('search', query);
        window.location.href = url;
    }

    function debouncedUpdateSearch(query) {
        clearTimeout(searchTimeout); // Clear the previous timeout
        searchTimeout = setTimeout(() => {
            updateSearch(query); // Call the update function after 1 seconds
        }, 1000); // 1000 milliseconds = 1 seconds
    }
</script>