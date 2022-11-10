package main

import (
	"testing"

	"github.com/kulti/titlecase"
	"github.com/stretchr/testify/assert"
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

type testCase struct {
	input string
	minor string
	want  string
}

func TestWithoutMinor(t *testing.T) {
	// передайте пустую строку в качестве второго агрумента

	testCases := []testCase{
		{input: "weather is good", minor: "", want: "Weather Is Good"},
		{input: "aaaa", minor: "", want: "Aaaa"},
		{input: "", minor: "", want: ""},
	}

	for _, tc := range testCases {
		got := titlecase.TitleCase(tc.input, tc.minor)
		assert.Equal(t, tc.want, got)
	}
}

func TestWithMinorInFirst(t *testing.T) {
	// передайте первое слово исходной строки в качестве второго аргумента
	testCases := []testCase{
		{input: "weather is good", minor: "weather", want: "Weather Is Good"},
		{input: "aaaa", minor: "aaaa", want: "Aaaa"},
		{input: "", minor: "", want: ""},
	}

	for _, tc := range testCases {
		got := titlecase.TitleCase(tc.input, tc.minor)
		assert.Equal(t, tc.want, got)
	}
}

func TestMoreTwoMinors(t *testing.T) {
	//minor string has more than one word
	testCases := []testCase{
		{input: "my name is denis", minor: "name is", want: "My name is Denis"},
		{input: "london is the capital of great britain", minor: "is the capital of", want: "London is the capital of Great Britain"},
		{input: "", minor: "", want: ""},
	}

	for _, tc := range testCases {
		got := titlecase.TitleCase(tc.input, tc.minor)
		assert.Equal(t, tc.want, got)
	}
}


