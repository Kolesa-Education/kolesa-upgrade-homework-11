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

var testCases = []struct {
	input string
	minor string
	expected string
}{
	{"the quick fox in the bag", "", "The Quick Fox In The Bag"},
	{"the quick fox in the bag", "in the", "The Quick Fox in the Bag"},
	{"the quick fox in the bag", "the quick", "The quick Fox In the Bag"},
	{"@the quick fox in the bag", "the", "@The Quick Fox In the Bag"},
	{"the quick @fox in the @bag", "@", "The Quick @Fox In The @Bag"},
	{"the quick fox in the bag", "t", "The Quick Fox In The Bag"},
}

func TestEmpty(t *testing.T) {
	for _, test := range testCases {
		got := titlecase.TitleCase(test.input, test.minor)
		if got != test.expected {
			t.Errorf("TitleCase(%v, %v) = %v; want %v", test.input, test.minor, got, test.expected)
		}
	}
}

func TestTitleCase(t *testing.T) {
	for _, test := range testCases {
		require.Equal(t, test.expected, titlecase.TitleCase(test.input, test.minor))
	}
}
