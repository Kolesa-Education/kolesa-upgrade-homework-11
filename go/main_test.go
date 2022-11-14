package main

import (
	"testing"

	"github.com/kulti/titlecase"
	"github.com/stretchr/testify/require"
)

// Задание
// 1. Дописать существующие тесты.
// 2. Придумать один новый тест.
//
// Дополнительное задание: использовать табличные тесты и testify.require

func TestTitleCase(t *testing.T) {
	kizikeken := []struct {
		name     string
		str      string
		minor    string
		expected string
	}{
		{"TestEmpty", "", "", ""},
		{"TestWithMinorInFirst", "", "in of the", ""},
		{"TestWithoutMinor", "asdas hjkhjn", "asdas", "xczczxz"},
		{"pridumalsvoi1", "qwE", "wEww", "WERFG"},
		{"pridumalsvoi2", "4ai", "s", "4ekoladom"},
		{"pridumalsvoi3", "@awd", "qw2es", "$aasd"},
	}

	for _, tc := range kizikeken {
		t.Run(tc.name, func(t *testing.T) {
			require.Equal(t, tc.expected, titlecase.TitleCase(tc.str, tc.minor))
		})
	}
}
