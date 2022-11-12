package main

import (
	"github.com/stretchr/testify/require"
	"testing"

	"github.com/kulti/titlecase"
)

// Задание
// 1. Дописать существующие тесты.
// 2. Придумать один новый тест.
//
// Дополнительное задание: использовать табличные тесты и testify.require
//
// Документация по тестируемой функции:
// Делает слова в строке из первого аргумента с большой буквы, кроме слов из строки из второго аргумента
// Первое слово всегда с большой буквы
//
// TitleCase(str, minor) returns a str string with all words capitalized except minor words.
// The first word is always capitalized.
//
// E.g.
// TitleCase("the quick fox in the bag", "") = "The Quick Fox In The Bag"
// TitleCase("the quick fox in the bag", "in the") = "The Quick Fox in the Bag"

func TestEmpty(t *testing.T) {
	const str, minor, want = "", "", ""
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}

func TestWithoutMinor(t *testing.T) {
	const str, minor, want = "the quick brown fox", "", "The Quick Brown Fox"
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}

func TestWithMinorInFirst(t *testing.T) {
	const str, minor, want = "the quick brown fox", "in of the", "The Quick Brown Fox"
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}

func TestWithCapital(t *testing.T) {
	const str, minor, want = "tHe QUICK brOWn foX IN The bag", "in of the", "The Quick Brown Fox in the Bag"
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}

func TestTitleCase(t *testing.T) {
	tests := []struct {
		name     string
		str      string
		minor    string
		expected string
	}{
		{"empty", "", "", ""},
		{"wo_str", "", "my name is", ""},
		{"wo_minor", "hello my name is almat", "my name is", "Hello my name is Almat"},
		{"minor_first", "am i a student", "am a student", "Am I student"},
		{"full", "hello my name is almat", "my name is", "Hello my name is Almat"},
		{"with_capital", "Hello My Name Is Almat", "my name is", "Hello my name is Almat"},
	}

	for _, tc := range tests {
		t.Run(tc.name, func(t *testing.T) {
			t.Parallel()
			require.Equal(t, tc.expected, titlecase.TitleCase(tc.str, tc.minor))
		})
	}
}
