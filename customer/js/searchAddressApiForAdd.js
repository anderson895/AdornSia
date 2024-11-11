    //fuzzy search algorithm to provide auto-correction suggestions


        // Define the filterBarangays function in the global scope
        function filterBarangays(searchValue, data, maxSuggestions) {
            // Filter barangays that match the search value
            let filteredBarangays = data.filter(function(barangay) {
                return barangay.brgy_name.toLowerCase().includes(searchValue);
            });
        
            // If no exact match is found, try to find suggestions
            if (filteredBarangays.length === 0) {
                // Use a fuzzy search algorithm or simple correction logic
                // Here, we'll use a simple approach by checking Levenshtein distance
                filteredBarangays = data.map(function(barangay) {
                    return {
                        barangay: barangay,
                        distance: levenshteinDistance(searchValue, barangay.brgy_name.toLowerCase())
                    };
                }).sort(function(a, b) {
                    return a.distance - b.distance;
                }).slice(0, maxSuggestions)
                .map(function(item) {
                    return item.barangay;
                });
            }
        
            return filteredBarangays.slice(0, maxSuggestions);
        }
        
        // Function to calculate Levenshtein distance between two strings
        function levenshteinDistance(a, b) {
            if (a.length === 0) return b.length;
            if (b.length === 0) return a.length;
        
            const matrix = [];
        
            // Initialize the matrix
            for (let i = 0; i <= b.length; i++) {
                matrix[i] = [i];
            }
        
            for (let j = 0; j <= a.length; j++) {
                matrix[0][j] = j;
            }
        
            // Fill in the matrix
            for (let i = 1; i <= b.length; i++) {
                for (let j = 1; j <= a.length; j++) {
                    if (b.charAt(i - 1) === a.charAt(j - 1)) {
                        matrix[i][j] = matrix[i - 1][j - 1];
                    } else {
                        matrix[i][j] = Math.min(
                            matrix[i - 1][j - 1] + 1,
                            matrix[i][j - 1] + 1,
                            matrix[i - 1][j] + 1
                        );
                    }
                }
            }
        
            return matrix[b.length][a.length];
        }



     
        

        

        function getCompleteAddress(barangayData, regionData, provinceData, cityData) {
            var selectedRegion = regionData.find(function(region) {
                return region.region_code === barangayData.region_code;
            });
        
            var selectedProvince = provinceData.find(function(province) {
                return province.province_code === barangayData.province_code;
            });
        
            var selectedCity = cityData.find(function(city) {
                return city.city_code === barangayData.city_code;
            });
        
            return (selectedRegion ? selectedRegion.region_name : 'N/A') +
                ' ' + (selectedProvince ? selectedProvince.province_name : 'N/A') +
                ' ' + (selectedCity ? selectedCity.city_name : 'N/A') +
                ' ' + barangayData.brgy_name;
        }
        



        $(document).ready(function() {
            var barangayData, regionData, provinceData, cityData;
            var maxSuggestions = 5;

            // Load barangay data
            $.getJSON('../ph-json/barangay.json', function(response) {
                barangayData = response.data;

               
            });

            // Load region data
            $.getJSON('../ph-json/region.json', function(response) {
                regionData = response.data;
            });

            // Load province data
            $.getJSON('../ph-json/province.json', function(response) {
                provinceData = response.data;
            });

            // Load city data
            $.getJSON('../ph-json/city.json', function(response) {
                cityData = response.data;
            });

            $('#searchBarangay_add').on('input', function() {

                console.log("triger")

                var searchValue = $(this).val().toLowerCase();
                var filteredBarangays = filterBarangays(searchValue, barangayData, maxSuggestions);

                $('#barangaySuggestions_add').empty();

                $.each(filteredBarangays, function(key, value) {
                    // Create a new div element with the class "suggestion-item" and the barangay name
                    var suggestionItem = $('<div class="suggestion-item" data-suggestion="' + value.brgy_code + '">' + getCompleteAddress(value, regionData, provinceData, cityData) + '</div>');


                
                    // Add a hover effect to the dynamically created element
                    suggestionItem.hover(
                        function() {
                            // Mouse over - add your hover effect here
                            $(this).css('background-color', 'lightgray'); // Change background color, for example
                        },
                        function() {
                            // Mouse out - remove the hover effect here
                            $(this).css('background-color', ''); // Reset background color
                        }
                    );
                
                    // Append the dynamically created element to the '#barangaySuggestions' div
                    $('#barangaySuggestions_add').append(suggestionItem);
                });
                

                if (filteredBarangays.length > 0) {
                    $('#barangaySuggestions_add').show();
                } else {
                    $('#barangaySuggestions_add').hide();
                }
            });

            $(document).on('click', function(event) {
                if (!$(event.target).closest('.search-container').length) {
                    $('#barangaySuggestions_add').hide();
                }
            });




            $('#barangaySuggestions_add').on('click', '.suggestion-item', function() {
                var selectedBrgy_add = $(this).attr("data-suggestion");
             //   $('#searchBarangay_add').val(selectedBrgy_add);
                $('#barangaySuggestions_add').hide();
                $('#complete_Address_code').val(selectedBrgy_add);
                
                console.log(selectedBrgy_add);

                var selectedBrgyData = barangayData.find(function(barangay) {
                    return barangay.brgy_code === selectedBrgy_add;
                });

                if (selectedBrgyData) {
                    // Fetch names from region, province, city using the codes
                    var selectedRegion = regionData.find(function(region) {
                        return region.region_code === selectedBrgyData.region_code;
                    });

                    var selectedProvince = provinceData.find(function(province) {
                        return province.province_code === selectedBrgyData.province_code;
                    });

                    var selectedCity = cityData.find(function(city) {
                        return city.city_code === selectedBrgyData.city_code;
                    });

                    // Display the names in the respective input fields
                    $('#region_add').val(selectedRegion ? selectedRegion.region_code : 'N/A');
                    $('#province_add').val(selectedProvince ? selectedProvince.province_code : 'N/A');
                    $('#city_add').val(selectedCity ? selectedCity.city_code : 'N/A');
                    $('#brgy_add').val(selectedBrgyData.brgy_code);

                    // Display the complete address in the textarea
                    var completeAddress_add = (selectedRegion ? selectedRegion.region_name : 'N/A') +
                                        ' ' + (selectedProvince ? selectedProvince.province_name : 'N/A') +
                                        ' ' + (selectedCity ? selectedCity.city_name : 'N/A') +
                                        ' ' + selectedBrgyData.brgy_name;

                    
                    $('#complete_address_add').val(completeAddress_add);
                    $('#complete_address_add').show();
                    
                }
            });

            
        });




        